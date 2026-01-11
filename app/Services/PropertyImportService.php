<?php

namespace App\Services;

use App\Models\Property;
use App\Models\PropertyUnit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PropertyImportService
{
    /**
     * Get all property fields that can be imported
     */
    public function getPropertyFields()
    {
        return [
            'property_name' => [
                'label' => __('Property Name'),
                'required' => true,
                'type' => 'string',
            ],
            'property_address' => [
                'label' => __('Property Address'),
                'required' => true,
                'type' => 'string',
            ],
            'property_description' => [
                'label' => __('Description'),
                'required' => false,
                'type' => 'text',
            ],
            'property_type' => [
                'label' => __('Type'),
                'required' => false,
                'type' => 'string',
                'options' => ['own_property', 'lease_property'],
            ],
            'property_country' => [
                'label' => __('Country'),
                'required' => false,
                'type' => 'string',
            ],
            'property_state' => [
                'label' => __('State'),
                'required' => false,
                'type' => 'string',
            ],
            'property_city' => [
                'label' => __('City'),
                'required' => false,
                'type' => 'string',
            ],
            'property_zip_code' => [
                'label' => __('Zip Code'),
                'required' => false,
                'type' => 'string',
            ],
            'property_listing_type' => [
                'label' => __('Listing Type'),
                'required' => false,
                'type' => 'string',
            ],
            'property_price' => [
                'label' => __('Price'),
                'required' => false,
                'type' => 'numeric',
            ],
        ];
    }

    /**
     * Get all unit fields that can be imported
     */
    public function getUnitFields()
    {
        return [
            'unit_name' => [
                'label' => __('Unit Name'),
                'required' => true,
                'type' => 'string',
            ],
            'unit_bedroom' => [
                'label' => __('Bedrooms'),
                'required' => false,
                'type' => 'integer',
            ],
            'unit_baths' => [
                'label' => __('Bathrooms'),
                'required' => false,
                'type' => 'integer',
            ],
            'unit_kitchen' => [
                'label' => __('Kitchen'),
                'required' => false,
                'type' => 'integer',
            ],
            'unit_rent' => [
                'label' => __('Rent'),
                'required' => false,
                'type' => 'numeric',
            ],
            'unit_deposit_amount' => [
                'label' => __('Deposit Amount'),
                'required' => false,
                'type' => 'numeric',
            ],
            'unit_deposit_type' => [
                'label' => __('Deposit Type'),
                'required' => false,
                'type' => 'string',
                'options' => ['fixed', 'percentage'],
            ],
            'unit_late_fee_type' => [
                'label' => __('Late Fee Type'),
                'required' => false,
                'type' => 'string',
                'options' => ['fixed', 'percentage'],
            ],
            'unit_late_fee_amount' => [
                'label' => __('Late Fee Amount'),
                'required' => false,
                'type' => 'numeric',
            ],
            'unit_incident_receipt_amount' => [
                'label' => __('Incident Receipt Amount'),
                'required' => false,
                'type' => 'numeric',
            ],
            'unit_rent_type' => [
                'label' => __('Rent Type'),
                'required' => false,
                'type' => 'string',
                'options' => ['monthly', 'yearly', 'custom'],
            ],
            'unit_rent_duration' => [
                'label' => __('Rent Duration'),
                'required' => false,
                'type' => 'integer',
            ],
            'unit_start_date' => [
                'label' => __('Start Date'),
                'required' => false,
                'type' => 'date',
            ],
            'unit_end_date' => [
                'label' => __('End Date'),
                'required' => false,
                'type' => 'date',
            ],
            'unit_payment_due_date' => [
                'label' => __('Payment Due Date'),
                'required' => false,
                'type' => 'date',
            ],
            'unit_notes' => [
                'label' => __('Notes'),
                'required' => false,
                'type' => 'text',
            ],
        ];
    }

    /**
     * Auto-map common field names
     */
    public function autoMapFields(array $headings)
    {
        $mappings = [];
        $allFields = array_merge($this->getPropertyFields(), $this->getUnitFields());

        // Common field name variations
        $fieldVariations = [
            'property_name' => ['property name', 'property', 'name', 'building name', 'property title'],
            'property_address' => ['property address', 'address', 'property location', 'location', 'full address'],
            'unit_name' => ['unit name', 'unit', 'unit number', 'apartment', 'apt', 'unit #'],
            'unit_rent' => ['rent', 'rental', 'rent amount', 'monthly rent', 'price'],
            'unit_bedroom' => ['bedroom', 'bedrooms', 'beds', 'bed'],
            'unit_baths' => ['bathroom', 'bathrooms', 'baths', 'bath'],
            'unit_kitchen' => ['kitchen', 'kitchens'],
            'property_type' => ['property type', 'type', 'property category'],
            'property_city' => ['city', 'property city'],
            'property_state' => ['state', 'property state', 'province'],
            'property_country' => ['country', 'property country'],
            'property_zip_code' => ['zip code', 'zip', 'postal code', 'postcode'],
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
                    if ($headingLower === $fieldLabel || $headingLower === str_replace('property ', '', $fieldLabel) || $headingLower === str_replace('unit ', '', $fieldLabel)) {
                        $mappings[$field] = $heading;
                        break;
                    }
                }
            }
        }

        return $mappings;
    }

    /**
     * Validate import data
     */
    public function validateImportData(string $filePath, array $mappings)
    {
        $fullPath = Storage::path($filePath);
        $data = Excel::toArray([], $fullPath);
        $rows = array_slice($data[0], 1); // Skip header
        $headings = $data[0][0];

        $errors = [];
        $groupedData = [];
        $propertiesToCreate = [];
        $unitsToCreate = 0;

        foreach ($rows as $rowIndex => $row) {
            $rowNumber = $rowIndex + 2; // +2 because we start from row 2 (1 is header, array is 0-indexed)
            $rowData = array_combine($headings, $row);

            // Map row data according to mappings
            $mappedData = [];
            foreach ($mappings as $field => $column) {
                if ($column !== 'ignore' && isset($rowData[$column])) {
                    $mappedData[$field] = $rowData[$column];
                }
            }

            // Validate required fields
            if (empty($mappedData['property_name'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'property_name',
                    'message' => __('Property name is required.'),
                ];
                continue;
            }

            if (empty($mappedData['property_address'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'property_address',
                    'message' => __('Property address is required.'),
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

            // Validate rent is numeric if provided
            if (isset($mappedData['unit_rent']) && !empty($mappedData['unit_rent']) && !is_numeric($mappedData['unit_rent'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'unit_rent',
                    'message' => __('Rent must be a valid number.'),
                ];
            }

            // Validate rent_type if provided
            if (isset($mappedData['unit_rent_type']) && !empty($mappedData['unit_rent_type'])) {
                $validRentTypes = ['monthly', 'yearly', 'custom'];
                if (!in_array(strtolower($mappedData['unit_rent_type']), $validRentTypes)) {
                    $errors[] = [
                        'row' => $rowNumber,
                        'field' => 'unit_rent_type',
                        'message' => __('Rent type must be: monthly, yearly, or custom.'),
                    ];
                }
            }

            // Group by property (name + address)
            $propertyKey = trim($mappedData['property_name']) . '|' . trim($mappedData['property_address']);
            
            if (!isset($groupedData[$propertyKey])) {
                $groupedData[$propertyKey] = [
                    'property' => [
                        'name' => trim($mappedData['property_name']),
                        'address' => trim($mappedData['property_address']),
                        'description' => $mappedData['property_description'] ?? null,
                        'type' => $mappedData['property_type'] ?? null,
                        'country' => $mappedData['property_country'] ?? null,
                        'state' => $mappedData['property_state'] ?? null,
                        'city' => $mappedData['property_city'] ?? null,
                        'zip_code' => $mappedData['property_zip_code'] ?? null,
                        'listing_type' => $mappedData['property_listing_type'] ?? null,
                        'price' => isset($mappedData['property_price']) && is_numeric($mappedData['property_price']) ? $mappedData['property_price'] : 0,
                    ],
                    'units' => [],
                ];
                $propertiesToCreate[$propertyKey] = true;
            }

            // Add unit to property
            $groupedData[$propertyKey]['units'][] = [
                'name' => trim($mappedData['unit_name']),
                'bedroom' => isset($mappedData['unit_bedroom']) && is_numeric($mappedData['unit_bedroom']) ? (int)$mappedData['unit_bedroom'] : 0,
                'baths' => isset($mappedData['unit_baths']) && is_numeric($mappedData['unit_baths']) ? (int)$mappedData['unit_baths'] : 0,
                'kitchen' => isset($mappedData['unit_kitchen']) && is_numeric($mappedData['unit_kitchen']) ? (int)$mappedData['unit_kitchen'] : 0,
                'rent' => isset($mappedData['unit_rent']) && is_numeric($mappedData['unit_rent']) ? (float)$mappedData['unit_rent'] : 0,
                'deposit_amount' => isset($mappedData['unit_deposit_amount']) && is_numeric($mappedData['unit_deposit_amount']) ? (float)$mappedData['unit_deposit_amount'] : 0,
                'deposit_type' => $mappedData['unit_deposit_type'] ?? null,
                'late_fee_type' => $mappedData['unit_late_fee_type'] ?? null,
                'late_fee_amount' => isset($mappedData['unit_late_fee_amount']) && is_numeric($mappedData['unit_late_fee_amount']) ? (float)$mappedData['unit_late_fee_amount'] : 0,
                'incident_receipt_amount' => isset($mappedData['unit_incident_receipt_amount']) && is_numeric($mappedData['unit_incident_receipt_amount']) ? (float)$mappedData['unit_incident_receipt_amount'] : 0,
                'rent_type' => $mappedData['unit_rent_type'] ?? 'monthly',
                'rent_duration' => isset($mappedData['unit_rent_duration']) && is_numeric($mappedData['unit_rent_duration']) ? (int)$mappedData['unit_rent_duration'] : 0,
                'start_date' => !empty($mappedData['unit_start_date']) ? $this->parseDate($mappedData['unit_start_date']) : null,
                'end_date' => !empty($mappedData['unit_end_date']) ? $this->parseDate($mappedData['unit_end_date']) : null,
                'payment_due_date' => !empty($mappedData['unit_payment_due_date']) ? $this->parseDate($mappedData['unit_payment_due_date']) : null,
                'notes' => $mappedData['unit_notes'] ?? null,
            ];
            $unitsToCreate++;
        }

        return [
            'errors' => $errors,
            'grouped_data' => $groupedData,
            'properties_count' => count($propertiesToCreate),
            'units_count' => $unitsToCreate,
            'total_rows' => count($rows),
        ];
    }

    /**
     * Execute the import
     */
    public function executeImport(string $filePath, array $mappings)
    {
        // ValidateImportData already uses Storage::path, so we just need to ensure file exists
        if (!Storage::exists($filePath)) {
            throw new \Exception(__('File not found. Please upload again.'));
        }
        
        $validation = $this->validateImportData($filePath, $mappings);

        if (!empty($validation['errors'])) {
            throw new \Exception(__('Cannot import. Please fix validation errors first.'));
        }

        $groupedData = $validation['grouped_data'];
        $propertiesCreated = 0;
        $unitsCreated = 0;
        $rowsSkipped = 0;
        $skipReasons = [];

        DB::beginTransaction();

        try {
            foreach ($groupedData as $propertyKey => $data) {
                // Find or create property
                $property = Property::where('parent_id', parentId())
                    ->where('name', $data['property']['name'])
                    ->where('address', $data['property']['address'])
                    ->first();

                if (!$property) {
                    $property = new Property();
                    $property->name = $data['property']['name'];
                    $property->address = $data['property']['address'];
                    $property->description = $data['property']['description'];
                    $property->type = $data['property']['type'];
                    $property->country = $data['property']['country'];
                    $property->state = $data['property']['state'];
                    $property->city = $data['property']['city'];
                    $property->zip_code = $data['property']['zip_code'];
                    $property->listing_type = $data['property']['listing_type'];
                    $property->price = $data['property']['price'];
                    $property->parent_id = parentId();
                    $property->is_active = 1;
                    $property->save();
                    $propertiesCreated++;
                }

                // Create units
                foreach ($data['units'] as $unitData) {
                    // Check if unit already exists
                    $existingUnit = PropertyUnit::where('property_id', $property->id)
                        ->where('name', $unitData['name'])
                        ->where('parent_id', parentId())
                        ->first();

                    if ($existingUnit) {
                        $rowsSkipped++;
                        $skipReasons[] = [
                            'property' => $property->name,
                            'unit' => $unitData['name'],
                            'reason' => __('Unit already exists'),
                        ];
                        continue;
                    }

                    $unit = new PropertyUnit();
                    $unit->property_id = $property->id;
                    $unit->name = $unitData['name'];
                    $unit->bedroom = $unitData['bedroom'];
                    $unit->baths = $unitData['baths'];
                    $unit->kitchen = $unitData['kitchen'];
                    $unit->rent = $unitData['rent'];
                    $unit->deposit_amount = $unitData['deposit_amount'];
                    $unit->deposit_type = $unitData['deposit_type'];
                    $unit->late_fee_type = $unitData['late_fee_type'];
                    $unit->late_fee_amount = $unitData['late_fee_amount'];
                    $unit->incident_receipt_amount = $unitData['incident_receipt_amount'];
                    $unit->rent_type = $unitData['rent_type'];
                    $unit->rent_duration = $unitData['rent_duration'];
                    $unit->start_date = $unitData['start_date'];
                    $unit->end_date = $unitData['end_date'];
                    $unit->payment_due_date = $unitData['payment_due_date'];
                    $unit->notes = $unitData['notes'];
                    $unit->is_occupied = 0;
                    $unit->parent_id = parentId();
                    $unit->save();
                    $unitsCreated++;
                }
            }

            DB::commit();

            return [
                'properties_created' => $propertiesCreated,
                'units_created' => $unitsCreated,
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

