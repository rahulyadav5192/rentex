<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\Type;
use App\Services\InvoiceImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class InvoiceImportController extends Controller
{
    protected $importService;

    public function __construct(InvoiceImportService $importService)
    {
        $this->importService = $importService;
    }

    public function index()
    {
        if (!\Auth::user()->can('create invoice')) {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

        $fields = $this->importService->getInvoiceFields();
        $sampleData = $this->importService->getSampleData();

        return view('invoice.import.index', compact('fields', 'sampleData'));
    }

    public function upload(Request $request)
    {
        if (!\Auth::user()->can('create invoice')) {
            return response()->json(['error' => __('Permission Denied!')], 403);
        }

        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240', // 10MB max
            ],
        ]);

        $file = $request->file('file');
        
        // Validate file extension separately (more reliable for CSV files)
        $extension = strtolower($file->getClientOriginalExtension());
        $allowedExtensions = ['csv', 'xlsx', 'xls'];
        
        if (empty($extension) || !in_array($extension, $allowedExtensions)) {
            return response()->json([
                'error' => __('The file must be a file of type: csv, xlsx, xls. Current extension: :ext', ['ext' => $extension ?: 'none'])
            ], 422);
        }

        try {
            // Sanitize filename
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
            $sanitizedName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nameWithoutExt);
            $fileName = 'import_' . time() . '_' . $sanitizedName . '.' . $extension;
            
            $filePath = $file->storeAs('temp/imports', $fileName);

            if (!Storage::exists($filePath)) {
                throw new \Exception(__('File was not stored successfully.'));
            }

            $fullPath = Storage::path($filePath);
            
            if (!file_exists($fullPath)) {
                throw new \Exception(__('File not found at: ') . $fullPath);
            }

            // Get headers
            $headings = (new HeadingRowImport)->toArray($fullPath)[0][0];
            
            // Get first 3 rows for preview
            $previewData = Excel::toArray([], $fullPath);
            $previewRows = array_slice($previewData[0], 1, 3); // Skip header, get 3 rows

            // Store file path in session for next steps
            session(['invoice_import_file_path' => $filePath]);
            session(['invoice_import_headings' => $headings]);
            session(['invoice_import_preview' => $previewRows]);
            session(['invoice_import_total_rows' => count($previewData[0]) - 1]); // Exclude header

            return response()->json([
                'success' => true,
                'headings' => $headings,
                'preview' => $previewRows,
                'total_rows' => count($previewData[0]) - 1,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __('Failed to process file: ') . $e->getMessage()
            ], 500);
        }
    }

    public function mapping()
    {
        if (!\Auth::user()->can('create invoice')) {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

        $filePath = session('invoice_import_file_path');
        $headings = session('invoice_import_headings');
        $preview = session('invoice_import_preview');

        if (!$filePath || !$headings) {
            return redirect()->route('invoice.import.index')->with('error', __('Please upload a file first.'));
        }

        $fields = $this->importService->getInvoiceFields();
        $autoMapped = $this->importService->autoMapFields($headings);
        
        // Get all properties for manual selection dropdowns
        $properties = Property::where('parent_id', parentId())->get();

        return view('invoice.import.mapping', compact('headings', 'preview', 'fields', 'autoMapped', 'properties'));
    }

    public function validateImport(Request $request)
    {
        if (!\Auth::user()->can('create invoice')) {
            return response()->json(['error' => __('Permission Denied!')], 403);
        }

        $filePath = session('invoice_import_file_path');
        if (!$filePath || !Storage::exists($filePath)) {
            return response()->json(['error' => __('File not found. Please upload again.')], 404);
        }

        try {
            $mappings = $request->mappings ?? [];
            
            // Convert mapping values to integers (they come as strings from form)
            foreach ($mappings as $key => $value) {
                if ($value !== 'ignore' && $value !== '') {
                    $mappings[$key] = (int)$value;
                }
            }
            
            // Debug: Log received mappings
            \Log::info('Invoice Import Mappings Received:', ['mappings' => $mappings, 'all_request' => $request->all()]);
            
            $propertySelections = [];
            $unitSelections = [];
            $typeSelections = [];
            
            if ($request->has('property_selections')) {
                $propertySelections = is_array($request->property_selections) 
                    ? $request->property_selections 
                    : [];
            }
            
            if ($request->has('unit_selections')) {
                $unitSelections = is_array($request->unit_selections) 
                    ? $request->unit_selections 
                    : [];
            }
            
            if ($request->has('type_selections')) {
                $typeSelections = is_array($request->type_selections) 
                    ? $request->type_selections 
                    : [];
            }
            
            // Validate required mappings
            $requiredFields = ['property_name', 'unit_name', 'invoice_month', 'end_date', 'invoice_type', 'amount'];
            foreach ($requiredFields as $field) {
                // Check if mapping exists and is not 'ignore' or empty string
                // Note: 0 is a valid column index, so we check specifically for 'ignore' and empty string
                if (!isset($mappings[$field]) || $mappings[$field] === 'ignore' || $mappings[$field] === '') {
                    \Log::warning('Invoice Import: Missing required mapping', ['field' => $field, 'mappings' => $mappings]);
                    return response()->json([
                        'error' => __('Required field :field must be mapped.', ['field' => str_replace('_', ' ', $field)])
                    ], 422);
                }
            }

            // Process and validate data
            $result = $this->importService->validateImportData($filePath, $mappings, $propertySelections, $unitSelections, $typeSelections);

            // Store mappings, selections, and validation result in session
            session(['invoice_import_mappings' => $mappings]);
            session(['invoice_import_property_selections' => $propertySelections]);
            session(['invoice_import_unit_selections' => $unitSelections]);
            session(['invoice_import_type_selections' => $typeSelections]);
            session(['invoice_import_validation' => $result]);

            return response()->json([
                'success' => true,
                'validation' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __('Validation failed: ') . $e->getMessage()
            ], 500);
        }
    }

    public function import(Request $request)
    {
        if (!\Auth::user()->can('create invoice')) {
            if ($request->ajax()) {
                return response()->json(['error' => __('Permission Denied!')], 403);
            }
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

        $filePath = session('invoice_import_file_path');
        $mappings = session('invoice_import_mappings');
        
        // Get selections from request or session
        $propertySelections = $request->has('property_selections') && is_array($request->property_selections)
            ? $request->property_selections
            : session('invoice_import_property_selections', []);
        $unitSelections = $request->has('unit_selections') && is_array($request->unit_selections)
            ? $request->unit_selections
            : session('invoice_import_unit_selections', []);
        $typeSelections = session('invoice_import_type_selections', []);

        if (!$filePath || !$mappings) {
            if ($request->ajax()) {
                return response()->json(['error' => __('Import session expired. Please start over.')], 400);
            }
            return redirect()->route('invoice.import.index')->with('error', __('Import session expired. Please start over.'));
        }

        try {
            $result = $this->importService->executeImport($filePath, $mappings, $propertySelections, $unitSelections, $typeSelections);

            // Clear session data
            session()->forget([
                'invoice_import_file_path',
                'invoice_import_headings',
                'invoice_import_preview',
                'invoice_import_mappings',
                'invoice_import_property_selections',
                'invoice_import_unit_selections',
                'invoice_import_type_selections',
                'invoice_import_validation',
                'invoice_import_total_rows'
            ]);

            // Store result for result page
            session(['invoice_import_result' => $result]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('Import completed successfully.'),
                    'result' => $result
                ]);
            }

            return redirect()->route('invoice.import.result');
        } catch (\Exception $e) {
            \Log::error('Invoice Import Failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => __('Import failed: ') . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', __('Import failed: ') . $e->getMessage());
        }
    }

    public function result()
    {
        if (!\Auth::user()->can('create invoice')) {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

        $result = session('invoice_import_result');
        if (!$result) {
            return redirect()->route('invoice.import.index');
        }

        return view('invoice.import.result', compact('result'));
    }

    public function cancel()
    {
        session()->forget([
            'invoice_import_file_path',
            'invoice_import_headings',
            'invoice_import_preview',
            'invoice_import_mappings',
            'invoice_import_validation',
            'invoice_import_total_rows'
        ]);

        return redirect()->route('invoice.index');
    }

    public function getUnits(Request $request)
    {
        $propertyId = $request->property_id;
        $units = PropertyUnit::where('property_id', $propertyId)
            ->where('parent_id', parentId())
            ->get()
            ->map(function($unit) {
                return [
                    'id' => $unit->id,
                    'name' => $unit->name
                ];
            });
        
        return response()->json($units->values()->toArray());
    }
}

