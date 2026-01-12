<?php

namespace App\Services;

use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class TenantImportService
{
    /**
     * Get all tenant fields that can be imported
     */
    public function getTenantFields()
    {
        return [
            'first_name' => [
                'label' => __('First Name'),
                'required' => true,
                'type' => 'string',
            ],
            'last_name' => [
                'label' => __('Last Name'),
                'required' => true,
                'type' => 'string',
            ],
            'email' => [
                'label' => __('Email'),
                'required' => true,
                'type' => 'email',
            ],
            'password' => [
                'label' => __('Password'),
                'required' => true,
                'type' => 'string',
            ],
            'phone_number' => [
                'label' => __('Phone Number'),
                'required' => true,
                'type' => 'string',
            ],
            'family_member' => [
                'label' => __('Family Members'),
                'required' => false,
                'type' => 'integer',
            ],
            'address' => [
                'label' => __('Address'),
                'required' => false,
                'type' => 'text',
            ],
            'country' => [
                'label' => __('Country'),
                'required' => false,
                'type' => 'string',
            ],
            'state' => [
                'label' => __('State'),
                'required' => false,
                'type' => 'string',
            ],
            'city' => [
                'label' => __('City'),
                'required' => false,
                'type' => 'string',
            ],
            'zip_code' => [
                'label' => __('Zip Code'),
                'required' => false,
                'type' => 'string',
            ],
            'property_name' => [
                'label' => __('Property Name'),
                'required' => true,
                'type' => 'string',
            ],
            'unit_name' => [
                'label' => __('Unit Name'),
                'required' => true,
                'type' => 'string',
            ],
            'lease_start_date' => [
                'label' => __('Lease Start Date'),
                'required' => false,
                'type' => 'date',
            ],
            'lease_end_date' => [
                'label' => __('Lease End Date'),
                'required' => false,
                'type' => 'date',
            ],
        ];
    }

    /**
     * Auto-map common field names
     */
    public function autoMapFields(array $headings)
    {
        $mappings = [];
        $allFields = $this->getTenantFields();

        // Common field name variations
        $fieldVariations = [
            'first_name' => ['first name', 'firstname', 'fname', 'given name'],
            'last_name' => ['last name', 'lastname', 'lname', 'surname', 'family name'],
            'email' => ['email', 'e-mail', 'email address'],
            'password' => ['password', 'pwd', 'pass'],
            'phone_number' => ['phone number', 'phone', 'mobile', 'mobile number', 'contact number', 'tel'],
            'family_member' => ['family member', 'family members', 'total family', 'family size'],
            'address' => ['address', 'street address', 'full address'],
            'country' => ['country'],
            'state' => ['state', 'province'],
            'city' => ['city'],
            'zip_code' => ['zip code', 'zip', 'postal code', 'postcode'],
            'property_name' => ['property name', 'property', 'building name', 'property title'],
            'unit_name' => ['unit name', 'unit', 'unit number', 'apartment', 'apt', 'unit #'],
            'lease_start_date' => ['lease start date', 'start date', 'lease start', 'lease begin'],
            'lease_end_date' => ['lease end date', 'end date', 'lease end', 'lease expires'],
        ];

        foreach ($headings as $heading) {
            $headingLower = strtolower(trim($heading));
            $mapped = false;

            foreach ($fieldVariations as $field => $variations) {
                if (in_array($headingLower, $variations)) {
                    $mappings[$field] = $heading;
                    $mapped = true;
                    break;
                }
            }

            if (!$mapped) {
                // Try exact match with field name
                foreach ($allFields as $field => $config) {
                    $fieldLabel = strtolower(str_replace('_', ' ', $field));
                    if ($headingLower === $fieldLabel) {
                        $mappings[$field] = $heading;
                        break;
                    }
                }
            }
        }

        return $mappings;
    }

    /**
     * Normalize string for matching (trim + lowercase)
     */
    private function normalizeString($string)
    {
        return strtolower(trim($string));
    }

    /**
     * Find property by name (trim + lowercase match)
     */
    public function findPropertyByName($propertyName, $parentId)
    {
        $normalized = $this->normalizeString($propertyName);
        
        $properties = Property::where('parent_id', $parentId)->get();
        
        foreach ($properties as $property) {
            if ($this->normalizeString($property->name) === $normalized) {
                return $property;
            }
        }
        
        return null;
    }

    /**
     * Find unit by name within a property (trim + lowercase match)
     */
    public function findUnitByName($unitName, $propertyId, $parentId)
    {
        $normalized = $this->normalizeString($unitName);
        
        $units = PropertyUnit::where('property_id', $propertyId)
            ->where('parent_id', $parentId)
            ->get();
        
        foreach ($units as $unit) {
            if ($this->normalizeString($unit->name) === $normalized) {
                return $unit;
            }
        }
        
        return null;
    }

    /**
     * Get all properties for selection dropdown
     */
    public function getAllProperties($parentId)
    {
        return Property::where('parent_id', $parentId)
            ->orderBy('name')
            ->get()
            ->map(function ($property) {
                return [
                    'id' => $property->id,
                    'name' => $property->name,
                ];
            });
    }

    /**
     * Get all units for a property
     */
    public function getUnitsByProperty($propertyId, $parentId)
    {
        return PropertyUnit::where('property_id', $propertyId)
            ->where('parent_id', $parentId)
            ->orderBy('name')
            ->get()
            ->map(function ($unit) {
                return [
                    'id' => $unit->id,
                    'name' => $unit->name,
                ];
            });
    }

    /**
     * Validate import data
     */
    public function validateImportData(string $filePath, array $mappings, array $propertySelections = [], array $unitSelections = [])
    {
        $fullPath = Storage::path($filePath);
        $data = Excel::toArray([], $fullPath);
        $rows = array_slice($data[0], 1); // Skip header
        $headings = $data[0][0];

        $errors = [];
        $tenantsToCreate = [];
        $unmatchedProperties = [];
        $unmatchedUnits = [];
        $parentId = parentId();

        foreach ($rows as $rowIndex => $row) {
            $rowNumber = $rowIndex + 2; // +2 because we start from row 2
            $rowData = array_combine($headings, $row);

            // Map row data according to mappings
            $mappedData = [];
            foreach ($mappings as $field => $column) {
                if ($column !== 'ignore' && isset($rowData[$column])) {
                    $mappedData[$field] = $rowData[$column];
                }
            }

            // Validate required fields
            if (empty($mappedData['first_name'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'first_name',
                    'message' => __('First name is required.'),
                ];
                continue;
            }

            if (empty($mappedData['last_name'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'last_name',
                    'message' => __('Last name is required.'),
                ];
                continue;
            }

            if (empty($mappedData['email'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'email',
                    'message' => __('Email is required.'),
                ];
                continue;
            }

            // Check if email already exists
            if (User::where('email', $mappedData['email'])->exists()) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'email',
                    'message' => __('Email already exists: :email', ['email' => $mappedData['email']]),
                ];
                continue;
            }

            if (empty($mappedData['password'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'password',
                    'message' => __('Password is required.'),
                ];
                continue;
            }

            if (empty($mappedData['phone_number'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'phone_number',
                    'message' => __('Phone number is required.'),
                ];
                continue;
            }

            if (empty($mappedData['property_name'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'property_name',
                    'message' => __('Property name is required.'),
                ];
                continue;
            }

            if (empty($mappedData['unit_name'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'unit_name',
                    'message' => __('Unit name is required.'),
                ];
                continue;
            }

            // Try to find property
            $property = null;
            $propertyKey = 'row_' . $rowNumber;
            
            // Check if property was manually selected
            if (!empty($propertySelections) && isset($propertySelections[$propertyKey]) && !empty($propertySelections[$propertyKey])) {
                $selectedPropertyId = (int)$propertySelections[$propertyKey];
                if ($selectedPropertyId > 0) {
                    $property = Property::where('id', $selectedPropertyId)
                        ->where('parent_id', $parentId)
                        ->first();
                    
                    \Log::info('Using selected property', [
                        'row' => $rowNumber,
                        'property_key' => $propertyKey,
                        'selected_id' => $selectedPropertyId,
                        'property_found' => $property ? 'yes' : 'no'
                    ]);
                }
            }
            
            // If property not found via selection, try to auto-match
            if (!$property) {
                $property = $this->findPropertyByName($mappedData['property_name'], $parentId);
                \Log::info('Auto-matching property', [
                    'row' => $rowNumber,
                    'property_name' => $mappedData['property_name'],
                    'property_found' => $property ? 'yes' : 'no'
                ]);
            }

            if (!$property) {
                $unmatchedProperties[$propertyKey] = [
                    'row' => $rowNumber,
                    'property_name' => $mappedData['property_name'],
                    'first_name' => $mappedData['first_name'],
                    'last_name' => $mappedData['last_name'],
                ];
                continue;
            }

            // Try to find unit
            $unit = null;
            
            // Check if unit was manually selected
            if (!empty($unitSelections) && isset($unitSelections[$propertyKey]) && !empty($unitSelections[$propertyKey])) {
                $selectedUnitId = (int)$unitSelections[$propertyKey];
                if ($selectedUnitId > 0) {
                    $unit = PropertyUnit::where('id', $selectedUnitId)
                        ->where('property_id', $property->id)
                        ->where('parent_id', $parentId)
                        ->first();
                    
                    \Log::info('Using selected unit', [
                        'row' => $rowNumber,
                        'property_key' => $propertyKey,
                        'selected_id' => $selectedUnitId,
                        'property_id' => $property->id,
                        'unit_found' => $unit ? 'yes' : 'no'
                    ]);
                }
            }
            
            // If unit not found via selection, try to auto-match
            if (!$unit) {
                $unit = $this->findUnitByName($mappedData['unit_name'], $property->id, $parentId);
                \Log::info('Auto-matching unit', [
                    'row' => $rowNumber,
                    'unit_name' => $mappedData['unit_name'],
                    'property_id' => $property->id,
                    'unit_found' => $unit ? 'yes' : 'no'
                ]);
            }

            if (!$unit) {
                $unmatchedUnits[$propertyKey] = [
                    'row' => $rowNumber,
                    'property_id' => $property->id,
                    'property_name' => $property->name,
                    'unit_name' => $mappedData['unit_name'],
                    'first_name' => $mappedData['first_name'],
                    'last_name' => $mappedData['last_name'],
                ];
                continue;
            }

            // Check if unit is already occupied
            if ($unit->is_occupied == 1) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'unit',
                    'message' => __('Unit :unit is already occupied.', ['unit' => $unit->name]),
                ];
                continue;
            }

            // All validations passed, add to tenants to create
            $tenantsToCreate[] = [
                'row' => $rowNumber,
                'user' => [
                    'first_name' => trim($mappedData['first_name']),
                    'last_name' => trim($mappedData['last_name']),
                    'email' => trim($mappedData['email']),
                    'password' => $mappedData['password'],
                    'phone_number' => trim($mappedData['phone_number']),
                ],
                'tenant' => [
                    'family_member' => isset($mappedData['family_member']) && is_numeric($mappedData['family_member']) ? (int)$mappedData['family_member'] : 0,
                    'address' => $mappedData['address'] ?? null,
                    'country' => $mappedData['country'] ?? null,
                    'state' => $mappedData['state'] ?? null,
                    'city' => $mappedData['city'] ?? null,
                    'zip_code' => $mappedData['zip_code'] ?? null,
                    'property' => $property->id,
                    'unit' => $unit->id,
                    'lease_start_date' => !empty($mappedData['lease_start_date']) ? $this->parseDate($mappedData['lease_start_date']) : null,
                    'lease_end_date' => !empty($mappedData['lease_end_date']) ? $this->parseDate($mappedData['lease_end_date']) : null,
                ],
            ];
        }

        return [
            'errors' => $errors,
            'tenants_to_create' => $tenantsToCreate,
            'unmatched_properties' => $unmatchedProperties,
            'unmatched_units' => $unmatchedUnits,
            'total_rows' => count($rows),
        ];
    }

    /**
     * Execute the import
     */
    public function executeImport(string $filePath, array $mappings, array $propertySelections = [], array $unitSelections = [])
    {
        if (!Storage::exists($filePath)) {
            throw new \Exception(__('File not found. Please upload again.'));
        }
        
        $validation = $this->validateImportData($filePath, $mappings, $propertySelections, $unitSelections);

        if (!empty($validation['errors'])) {
            throw new \Exception(__('Cannot import. Please fix validation errors first.'));
        }

        if (!empty($validation['unmatched_properties']) || !empty($validation['unmatched_units'])) {
            throw new \Exception(__('Cannot import. Please select properties and units for all unmatched rows.'));
        }

        $tenantsToCreate = $validation['tenants_to_create'];
        $tenantsCreated = 0;
        $rowsSkipped = 0;
        $skipReasons = [];
        $parentId = parentId();

        // Get tenant role
        $userRole = Role::where('parent_id', $parentId)->where('name', 'tenant')->first();
        if (!$userRole) {
            throw new \Exception(__('Tenant role not found.'));
        }

        DB::beginTransaction();

        try {
            foreach ($tenantsToCreate as $tenantData) {
                // Check subscription limit
                $authUser = \App\Models\User::find($parentId);
                $totalTenant = $authUser->totalTenant();
                $subscription = \App\Models\Subscription::find($authUser->subscription);
                
                if ($totalTenant >= $subscription->tenant_limit && $subscription->tenant_limit != 0) {
                    $rowsSkipped++;
                    $skipReasons[] = [
                        'row' => $tenantData['row'],
                        'tenant' => $tenantData['user']['first_name'] . ' ' . $tenantData['user']['last_name'],
                        'reason' => __('Tenant limit exceeded. Please upgrade subscription.'),
                    ];
                    continue;
                }

                // Create user
                $user = new User();
                $user->first_name = $tenantData['user']['first_name'];
                $user->last_name = $tenantData['user']['last_name'];
                $user->email = $tenantData['user']['email'];
                $user->password = Hash::make($tenantData['user']['password']);
                $user->phone_number = $tenantData['user']['phone_number'];
                $user->type = $userRole->name;
                $user->email_verified_at = now();
                $user->profile = 'avatar.png';
                $user->lang = 'english';
                $user->parent_id = $parentId;
                $user->save();
                $user->assignRole($userRole);

                // Create tenant
                $tenant = new Tenant();
                $tenant->user_id = $user->id;
                $tenant->family_member = $tenantData['tenant']['family_member'];
                $tenant->address = $tenantData['tenant']['address'];
                $tenant->country = $tenantData['tenant']['country'];
                $tenant->state = $tenantData['tenant']['state'];
                $tenant->city = $tenantData['tenant']['city'];
                $tenant->zip_code = $tenantData['tenant']['zip_code'];
                $tenant->property = $tenantData['tenant']['property'];
                $tenant->unit = $tenantData['tenant']['unit'];
                $tenant->lease_start_date = $tenantData['tenant']['lease_start_date'];
                $tenant->lease_end_date = $tenantData['tenant']['lease_end_date'];
                $tenant->parent_id = $parentId;
                $tenant->save();

                // Mark unit as occupied
                $unit = PropertyUnit::find($tenant->unit);
                if ($unit) {
                    $unit->is_occupied = 1;
                    $unit->save();
                }

                $tenantsCreated++;
            }

            DB::commit();

            return [
                'tenants_created' => $tenantsCreated,
                'rows_skipped' => $rowsSkipped,
                'skip_reasons' => $skipReasons,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Parse date from various formats
     */
    private function parseDate($dateValue)
    {
        if (empty($dateValue)) {
            return null;
        }

        // If it's already a Carbon instance or DateTime
        if ($dateValue instanceof \DateTime) {
            return $dateValue->format('Y-m-d');
        }

        // Try to parse as date
        try {
            $date = \Carbon\Carbon::parse($dateValue);
            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}

