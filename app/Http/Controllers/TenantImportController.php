<?php

namespace App\Http\Controllers;

use App\Http\Requests\TenantImportRequest;
use App\Services\TenantImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class TenantImportController extends Controller
{
    protected $importService;

    public function __construct(TenantImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * Step 1: Show upload form
     */
    public function index()
    {
        if (!\Auth::user()->can('create tenant')) {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

        $tenantFields = $this->importService->getTenantFields();
        return view('tenant.import.index', compact('tenantFields'));
    }

    /**
     * Step 2: Upload and preview file
     */
    public function upload(Request $request)
    {
        if (!\Auth::user()->can('create tenant')) {
            return response()->json(['error' => __('Permission Denied!')], 403);
        }

        // Custom validation for file type (check extension, not MIME type)
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
            // Sanitize filename to avoid issues with spaces and special characters
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); // Get original extension (case preserved) for filename
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
            session(['tenant_import_file_path' => $filePath]);
            session(['tenant_import_headings' => $headings]);
            session(['tenant_import_preview' => $previewRows]);
            session(['tenant_import_total_rows' => count($previewData[0]) - 1]); // Exclude header

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
        if (!\Auth::user()->can('create tenant')) {
            return redirect()->route('tenant.index')->with('error', __('Permission Denied!'));
        }

        $filePath = session('tenant_import_file_path');
        if (!$filePath || !Storage::exists($filePath)) {
            return redirect()->route('tenant.import.index')->with('error', __('File not found. Please upload again.'));
        }

        $headings = session('tenant_import_headings', []);
        $preview = session('tenant_import_preview', []);

        // Get all mappable fields
        $tenantFields = $this->importService->getTenantFields();

        // Auto-map common field names
        $autoMappings = $this->importService->autoMapFields($headings);

        // Get all properties for selection
        $properties = $this->importService->getAllProperties(parentId());

        return view('tenant.import.mapping', compact('headings', 'preview', 'tenantFields', 'autoMappings', 'properties'));
    }

    /**
     * Step 4: Validate and preview data
     */
    public function validateImport(TenantImportRequest $request)
    {
        if (!\Auth::user()->can('create tenant')) {
            return response()->json(['error' => __('Permission Denied!')], 403);
        }

        $filePath = session('tenant_import_file_path');
        if (!$filePath || !Storage::exists($filePath)) {
            return response()->json(['error' => __('File not found. Please upload again.')], 404);
        }

        try {
            $mappings = $request->mappings;
            
            // Get property and unit selections - handle both array formats
            $propertySelections = [];
            $unitSelections = [];
            
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
            
            // Debug: Log received selections
            \Log::info('Tenant Import Validation', [
                'property_selections' => $propertySelections,
                'unit_selections' => $unitSelections,
                'property_selections_count' => count($propertySelections),
                'unit_selections_count' => count($unitSelections),
                'property_selections_keys' => array_keys($propertySelections),
                'unit_selections_keys' => array_keys($unitSelections),
                'all_request_keys' => array_keys($request->all()),
            ]);
            
            // Validate required mappings
            $requiredFields = ['first_name', 'last_name', 'email', 'password', 'phone_number', 'property_name', 'unit_name'];
            foreach ($requiredFields as $field) {
                if (empty($mappings[$field]) || $mappings[$field] === 'ignore') {
                    return response()->json([
                        'error' => __('Required field :field must be mapped.', ['field' => str_replace('_', ' ', $field)])
                    ], 422);
                }
            }

            // Process and validate data
            $result = $this->importService->validateImportData($filePath, $mappings, $propertySelections, $unitSelections);

            // Store mappings and validation result in session
            session(['tenant_import_mappings' => $mappings]);
            session(['tenant_import_property_selections' => $propertySelections]);
            session(['tenant_import_unit_selections' => $unitSelections]);
            session(['tenant_import_validation' => $result]);

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
     * Get units for a property (AJAX)
     */
    public function getUnits(Request $request)
    {
        $propertyId = $request->property_id;
        $units = $this->importService->getUnitsByProperty($propertyId, parentId());
        return response()->json($units);
    }

    /**
     * Step 5: Execute import
     */
    public function execute(Request $request)
    {
        if (!\Auth::user()->can('create tenant')) {
            return response()->json(['error' => __('Permission Denied!')], 403);
        }

        $filePath = session('tenant_import_file_path');
        $mappings = session('tenant_import_mappings');
        $propertySelections = session('tenant_import_property_selections', []);
        $unitSelections = session('tenant_import_unit_selections', []);
        $validation = session('tenant_import_validation');

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

        // Check if there are unmatched properties or units
        if (!empty($validation['unmatched_properties']) || !empty($validation['unmatched_units'])) {
            return response()->json([
                'error' => __('Cannot import. Please select properties and units for all unmatched rows.'),
                'unmatched_properties' => $validation['unmatched_properties'],
                'unmatched_units' => $validation['unmatched_units'],
            ], 422);
        }

        try {
            $result = $this->importService->executeImport($filePath, $mappings, $propertySelections, $unitSelections);

            // Clean up session and temp file
            Storage::delete($filePath);
            session()->forget([
                'tenant_import_file_path', 
                'tenant_import_headings', 
                'tenant_import_preview', 
                'tenant_import_mappings', 
                'tenant_import_property_selections',
                'tenant_import_unit_selections',
                'tenant_import_validation', 
                'tenant_import_total_rows'
            ]);

            // Store result in session for result page
            session(['tenant_import_result' => $result]);

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
        $importResult = session('tenant_import_result', []);
        return view('tenant.import.result', compact('importResult'));
    }

    /**
     * Cancel import and clean up
     */
    public function cancel()
    {
        $filePath = session('tenant_import_file_path');
        if ($filePath && Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
        
        session()->forget([
            'tenant_import_file_path', 
            'tenant_import_headings', 
            'tenant_import_preview', 
            'tenant_import_mappings', 
            'tenant_import_property_selections',
            'tenant_import_unit_selections',
            'tenant_import_validation', 
            'tenant_import_total_rows'
        ]);
        
        return redirect()->route('tenant.index')->with('success', __('Import cancelled.'));
    }
}

