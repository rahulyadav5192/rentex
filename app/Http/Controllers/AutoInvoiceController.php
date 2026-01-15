<?php

namespace App\Http\Controllers;

use App\Models\InvoiceGenerationLog;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\Type;
use App\Services\AutoInvoiceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutoInvoiceController extends Controller
{
    protected $autoInvoiceService;

    public function __construct(AutoInvoiceService $autoInvoiceService)
    {
        $this->autoInvoiceService = $autoInvoiceService;
    }

    /**
     * Display the auto invoice settings page
     */
    public function index()
    {
        if (!\Auth::user()->can('manage invoice')) {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

        $parentId = parentId();
        
        // Get all properties with their units
        $properties = Property::where('parent_id', $parentId)
            ->with(['totalUnits' => function($query) use ($parentId) {
                $query->where('parent_id', $parentId);
            }])
            ->orderBy('name')
            ->get();

        // Get invoice types for dropdown
        $invoiceTypes = Type::where('type', 'invoice')
            ->where(function($query) use ($parentId) {
                $query->where('parent_id', $parentId)
                      ->orWhere('parent_id', 0);
            })
            ->get()
            ->pluck('title', 'id');
        $invoiceTypes->prepend(__('Select Type'), '');

        // Get latest generation log
        $latestLog = InvoiceGenerationLog::where('parent_id', $parentId)
            ->orderBy('generation_date', 'desc')
            ->first();

        // Get the invoice_generation_day from enabled properties first, then any property
        $defaultGenerationDay = Property::where('parent_id', $parentId)
            ->where('auto_invoice_enabled', true)
            ->whereNotNull('invoice_generation_day')
            ->where('invoice_generation_day', '>', 0)
            ->value('invoice_generation_day');
        
        // If no enabled properties have it set, get from any property
        if (!$defaultGenerationDay) {
            $defaultGenerationDay = Property::where('parent_id', $parentId)
                ->whereNotNull('invoice_generation_day')
                ->where('invoice_generation_day', '>', 0)
                ->value('invoice_generation_day') ?? 1;
        }

        return view('auto-invoice.index', compact('properties', 'invoiceTypes', 'latestLog', 'defaultGenerationDay'));
    }

    /**
     * Update global settings
     */
    public function updateGlobalSettings(Request $request)
    {
        if (!\Auth::user()->can('manage invoice')) {
            return response()->json(['success' => false, 'message' => __('Permission Denied!')], 403);
        }

        $request->validate([
            'auto_invoice_enabled' => 'sometimes|boolean',
            'invoice_generation_day' => 'sometimes|integer|min:1|max:28',
        ]);

        $parentId = parentId();
        $autoInvoiceEnabled = $request->input('auto_invoice_enabled', false);
        $invoiceGenerationDay = $request->input('invoice_generation_day', 1);

        // Update all properties
        Property::where('parent_id', $parentId)
            ->update([
                'auto_invoice_enabled' => $autoInvoiceEnabled,
                'invoice_generation_day' => $invoiceGenerationDay,
            ]);

        // Update all units
        PropertyUnit::where('parent_id', $parentId)
            ->update([
                'auto_invoice_enabled' => $autoInvoiceEnabled,
            ]);

        return response()->json([
            'success' => true,
            'message' => __('Settings updated successfully'),
        ]);
    }

    /**
     * Update property settings
     */
    public function updatePropertySettings(Request $request, $propertyId)
    {
        if (!\Auth::user()->can('manage invoice')) {
            return response()->json(['success' => false, 'message' => __('Permission Denied!')], 403);
        }

        $request->validate([
            'auto_invoice_enabled' => 'sometimes|boolean',
            'invoice_generation_day' => 'sometimes|integer|min:1|max:28',
        ]);

        $property = Property::where('id', $propertyId)
            ->where('parent_id', parentId())
            ->firstOrFail();

        $property->update([
            'auto_invoice_enabled' => $request->input('auto_invoice_enabled', false),
            'invoice_generation_day' => $request->input('invoice_generation_day', $property->invoice_generation_day ?? 1),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('Property settings updated successfully'),
        ]);
    }

    /**
     * Update unit settings
     */
    public function updateUnitSettings(Request $request, $unitId)
    {
        if (!\Auth::user()->can('manage invoice')) {
            return response()->json(['success' => false, 'message' => __('Permission Denied!')], 403);
        }

        $request->validate([
            'auto_invoice_enabled' => 'sometimes|boolean',
            'default_invoice_type_id' => 'sometimes|nullable|exists:types,id',
        ]);

        $unit = PropertyUnit::where('id', $unitId)
            ->where('parent_id', parentId())
            ->firstOrFail();

        $unit->update([
            'auto_invoice_enabled' => $request->input('auto_invoice_enabled', false),
            'default_invoice_type_id' => $request->input('default_invoice_type_id'),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('Unit settings updated successfully'),
        ]);
    }

    /**
     * Preview invoices that would be generated
     */
    public function preview(Request $request)
    {
        if (!\Auth::user()->can('manage invoice')) {
            return response()->json(['success' => false, 'message' => __('Permission Denied!')], 403);
        }

        $request->validate([
            'month' => 'sometimes|date_format:Y-m',
        ]);

        $targetMonth = $request->input('month') 
            ? Carbon::createFromFormat('Y-m', $request->input('month'))
            : Carbon::now();

        $result = $this->autoInvoiceService->previewInvoices(parentId(), $targetMonth);

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }

    /**
     * Manually generate invoices
     */
    public function generate(Request $request)
    {
        if (!\Auth::user()->can('create invoice')) {
            return response()->json(['success' => false, 'message' => __('Permission Denied!')], 403);
        }

        $request->validate([
            'month' => 'sometimes|date_format:Y-m',
        ]);

        $targetMonth = $request->input('month') 
            ? Carbon::createFromFormat('Y-m', $request->input('month'))
            : Carbon::now();

        try {
            $result = $this->autoInvoiceService->generateInvoices(parentId(), $targetMonth, false);

            return response()->json([
                'success' => true,
                'message' => __('Invoices generated successfully'),
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error generating invoices: :error', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    /**
     * Get generation logs
     */
    public function logs()
    {
        if (!\Auth::user()->can('manage invoice')) {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

        $logs = InvoiceGenerationLog::where('parent_id', parentId())
            ->orderBy('generation_date', 'desc')
            ->paginate(20);

        return view('auto-invoice.logs', compact('logs'));
    }

    /**
     * Get log details
     */
    public function logDetails($id)
    {
        if (!\Auth::user()->can('manage invoice')) {
            return response()->json(['success' => false, 'message' => __('Permission Denied!')], 403);
        }

        $log = InvoiceGenerationLog::where('id', $id)
            ->where('parent_id', parentId())
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $log,
        ]);
    }
}
