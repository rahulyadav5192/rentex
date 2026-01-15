<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\Type;
use App\Services\ExpenseImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ExpenseImportController extends Controller
{
    protected $importService;

    public function __construct(ExpenseImportService $importService)
    {
        $this->importService = $importService;
    }

    public function index()
    {
        if (!\Auth::user()->can('create expense')) {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

        $fields = $this->importService->getExpenseFields();
        $sampleData = $this->importService->getSampleData();

        return view('expense.import.index', compact('fields', 'sampleData'));
    }

    public function upload(Request $request)
    {
        if (!\Auth::user()->can('create expense')) {
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
            session(['expense_import_file_path' => $filePath]);
            session(['expense_import_headings' => $headings]);
            session(['expense_import_preview' => $previewRows]);
            session(['expense_import_total_rows' => count($previewData[0]) - 1]); // Exclude header

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
        if (!\Auth::user()->can('create expense')) {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

        $filePath = session('expense_import_file_path');
        $headings = session('expense_import_headings');
        $preview = session('expense_import_preview');

        if (!$filePath || !$headings) {
            return redirect()->route('expense.import.index')->with('error', __('Please upload a file first.'));
        }

        $fields = $this->importService->getExpenseFields();
        $autoMapped = $this->importService->autoMapFields($headings);
        
        // Get all properties for manual selection dropdowns
        $properties = Property::where('parent_id', parentId())->get();

        return view('expense.import.mapping', compact('headings', 'preview', 'fields', 'autoMapped', 'properties'));
    }

    public function validateImport(Request $request)
    {
        if (!\Auth::user()->can('create expense')) {
            return response()->json(['error' => __('Permission Denied!')], 403);
        }

        $filePath = session('expense_import_file_path');
        if (!$filePath || !Storage::exists($filePath)) {
            return response()->json(['error' => __('File not found. Please upload again.')], 404);
        }

        try {
            $mappings = $request->mappings;
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
            $requiredFields = ['property_name', 'unit_name', 'expense_month', 'end_date', 'expense_type', 'amount'];
            foreach ($requiredFields as $field) {
                if (empty($mappings[$field]) || $mappings[$field] === 'ignore') {
                    return response()->json([
                        'error' => __('Required field :field must be mapped.', ['field' => str_replace('_', ' ', $field)])
                    ], 422);
                }
            }

            // Process and validate data
            $result = $this->importService->validateImportData($filePath, $mappings, $propertySelections, $unitSelections, $typeSelections);

            // Store mappings and validation result in session
            session(['expense_import_mappings' => $mappings]);
            session(['expense_import_validation' => $result]);

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __('Validation failed: ') . $e->getMessage()
            ], 500);
        }
    }

    public function import(Request $request)
    {
        if (!\Auth::user()->can('create expense')) {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

        $filePath = session('expense_import_file_path');
        $mappings = session('expense_import_mappings');

        if (!$filePath || !$mappings) {
            return redirect()->route('expense.import.index')->with('error', __('Import session expired. Please start over.'));
        }

        try {
            $result = $this->importService->executeImport($filePath, $mappings);

            // Clear session data
            session()->forget([
                'expense_import_file_path',
                'expense_import_headings',
                'expense_import_preview',
                'expense_import_mappings',
                'expense_import_validation',
                'expense_import_total_rows'
            ]);

            // Store result for result page
            session(['expense_import_result' => $result]);

            return redirect()->route('expense.import.result');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('Import failed: ') . $e->getMessage());
        }
    }

    public function result()
    {
        if (!\Auth::user()->can('create expense')) {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

        $result = session('expense_import_result');
        if (!$result) {
            return redirect()->route('expense.import.index');
        }

        return view('expense.import.result', compact('result'));
    }

    public function cancel()
    {
        session()->forget([
            'expense_import_file_path',
            'expense_import_headings',
            'expense_import_preview',
            'expense_import_mappings',
            'expense_import_validation',
            'expense_import_total_rows'
        ]);

        return redirect()->route('expense.index');
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

