<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyImportRequest;
use App\Services\PropertyImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class PropertyImportController extends Controller
{
    protected $importService;

    public function __construct(PropertyImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * Step 1: Show upload form
     */
    public function index()
    {
        if (!\Auth::user()->can('create property')) {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

        return view('property.import.index');
    }

    /**
     * Step 2: Upload and preview file
     */
    public function upload(Request $request)
    {
        if (!\Auth::user()->can('create property')) {
            return response()->json(['error' => __('Permission Denied!')], 403);
        }

        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:10240', // 10MB max
        ]);

        try {
            $file = $request->file('file');
            
            // Sanitize filename to avoid issues with spaces and special characters
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
            $sanitizedName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nameWithoutExt);
            $fileName = 'import_' . time() . '_' . $sanitizedName . '.' . $extension;
            
            $filePath = $file->storeAs('temp/imports', $fileName);

            // Verify file was stored
            if (!Storage::exists($filePath)) {
                throw new \Exception(__('File was not stored successfully.'));
            }

            // Get full path to the stored file
            $fullPath = Storage::path($filePath);
            
            // Verify file exists at full path
            if (!file_exists($fullPath)) {
                throw new \Exception(__('File not found at: ') . $fullPath);
            }

            // Get headers
            $headings = (new HeadingRowImport)->toArray($fullPath)[0][0];
            
            // Get first 3 rows for preview
            $previewData = Excel::toArray([], $fullPath);
            $previewRows = array_slice($previewData[0], 1, 3); // Skip header, get 3 rows

            // Store file path in session for next steps
            session(['import_file_path' => $filePath]);
            session(['import_headings' => $headings]);
            session(['import_preview' => $previewRows]);
            session(['import_total_rows' => count($previewData[0]) - 1]); // Exclude header

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

    /**
     * Step 3: Show column mapping interface
     */
    public function mapping()
    {
        if (!\Auth::user()->can('create property')) {
            return redirect()->route('property.index')->with('error', __('Permission Denied!'));
        }

        $filePath = session('import_file_path');
        if (!$filePath || !Storage::exists($filePath)) {
            return redirect()->route('property.import')->with('error', __('File not found. Please upload again.'));
        }

        $headings = session('import_headings', []);
        $preview = session('import_preview', []);

        // Get all mappable fields
        $propertyFields = $this->importService->getPropertyFields();
        $unitFields = $this->importService->getUnitFields();

        // Auto-map common field names
        $autoMappings = $this->importService->autoMapFields($headings);

        return view('property.import.mapping', compact('headings', 'preview', 'propertyFields', 'unitFields', 'autoMappings'));
    }

    /**
     * Step 4: Validate and preview grouped data
     */
    public function validateImport(PropertyImportRequest $request)
    {
        if (!\Auth::user()->can('create property')) {
            return response()->json(['error' => __('Permission Denied!')], 403);
        }

        $filePath = session('import_file_path');
        if (!$filePath || !Storage::exists($filePath)) {
            return response()->json(['error' => __('File not found. Please upload again.')], 404);
        }

        try {
            $mappings = $request->mappings;
            
            // Validate required mappings
            $requiredFields = ['property_name', 'property_address', 'unit_name'];
            foreach ($requiredFields as $field) {
                if (empty($mappings[$field]) || $mappings[$field] === 'ignore') {
                    return response()->json([
                        'error' => __('Required field :field must be mapped.', ['field' => str_replace('_', ' ', $field)])
                    ], 422);
                }
            }

            // Process and validate data
            $result = $this->importService->validateImportData($filePath, $mappings);

            // Store mappings and validation result in session
            session(['import_mappings' => $mappings]);
            session(['import_validation' => $result]);

            return response()->json([
                'success' => true,
                'validation' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __('Validation failed: ') . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Step 5: Execute import
     */
    public function import(Request $request)
    {
        if (!\Auth::user()->can('create property')) {
            return response()->json(['error' => __('Permission Denied!')], 403);
        }

        $filePath = session('import_file_path');
        $mappings = session('import_mappings');
        $validation = session('import_validation');

        if (!$filePath || !Storage::exists($filePath)) {
            return response()->json(['error' => __('File not found. Please upload again.')], 404);
        }

        if (!$mappings || !$validation) {
            return response()->json(['error' => __('Please complete mapping and validation first.')], 400);
        }

        // Check if there are errors
        if (!empty($validation['errors']) && count($validation['errors']) > 0) {
            return response()->json([
                'error' => __('Cannot import. Please fix validation errors first.'),
                'errors' => $validation['errors']
            ], 422);
        }

        try {
            $result = $this->importService->executeImport($filePath, $mappings);

            // Clean up session and temp file
            Storage::delete($filePath);
            session()->forget(['import_file_path', 'import_headings', 'import_preview', 'import_mappings', 'import_validation', 'import_total_rows']);

            // Store result in session for result page
            session(['import_result' => $result]);

            return response()->json([
                'success' => true,
                'result' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __('Import failed: ') . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Step 6: Show import results
     */
    public function result()
    {
        $importResult = session('import_result', []);
        return view('property.import.result', compact('importResult'));
    }

    /**
     * Cancel import and clean up
     */
    public function cancel()
    {
        $filePath = session('import_file_path');
        if ($filePath && Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
        
        session()->forget(['import_file_path', 'import_headings', 'import_preview', 'import_mappings', 'import_validation', 'import_total_rows']);
        
        return redirect()->route('property.index')->with('success', __('Import cancelled.'));
    }
}

