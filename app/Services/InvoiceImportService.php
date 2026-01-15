<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceImportService
{
    public function getInvoiceFields()
    {
        return [
            'required' => [
                'property_name' => ['label' => __('Property Name'), 'type' => 'text', 'description' => __('Name of the property (must match existing property)')],
                'unit_name' => ['label' => __('Unit Name'), 'type' => 'text', 'description' => __('Name of the unit (must match existing unit)')],
                'invoice_month' => ['label' => __('Invoice Month'), 'type' => 'date', 'description' => __('Supports: YYYY-MM, YYYY-MM-DD, DD/MM/YYYY, MM/DD/YYYY, Excel dates, and more')],
                'end_date' => ['label' => __('Invoice End Date'), 'type' => 'date', 'description' => __('Supports: YYYY-MM-DD, DD/MM/YYYY, MM/DD/YYYY, Excel dates, and more')],
                'invoice_type' => ['label' => __('Invoice Type'), 'type' => 'text', 'description' => __('Type name (will be created if not exists)')],
                'amount' => ['label' => __('Amount'), 'type' => 'number', 'description' => __('Numeric value, e.g., 1000.50')],
            ],
            'optional' => [
                'invoice_id' => ['label' => __('Invoice Number'), 'type' => 'text', 'description' => __('Invoice number (auto-generated if not provided)')],
                'notes' => ['label' => __('Notes'), 'type' => 'text', 'description' => __('Additional notes for the invoice')],
                'description' => ['label' => __('Description'), 'type' => 'text', 'description' => __('Description for the invoice item')],
            ]
        ];
    }

    public function getSampleData()
    {
        return [
            ['Property A', 'Unit 101', '2024-01', '2024-01-31', 'Rent', '1500.00', 'INV-001', 'Monthly rent invoice', 'Rent for January'],
            ['Property A', 'Unit 102', '2024-01', '2024-01-31', 'Maintenance', '200.00', 'INV-002', 'Maintenance fee', 'Monthly maintenance'],
            ['Property B', 'Unit 201', '2024-01', '2024-01-31', 'Rent', '2000.00', '', '', ''],
        ];
    }

    public function autoMapFields(array $headings)
    {
        $mapping = [];
        $fieldMap = [
            'property_name' => ['property', 'property name', 'property_name'],
            'unit_name' => ['unit', 'unit name', 'unit_name'],
            'invoice_month' => ['invoice month', 'month', 'invoice_month', 'date'],
            'end_date' => ['end date', 'end_date', 'due date', 'due_date'],
            'invoice_type' => ['type', 'invoice type', 'invoice_type', 'category'],
            'amount' => ['amount', 'price', 'cost', 'total'],
            'invoice_id' => ['invoice id', 'invoice_id', 'invoice number', 'invoice_number', 'id'],
            'notes' => ['notes', 'note', 'comment', 'comments'],
            'description' => ['description', 'desc', 'details'],
        ];

        foreach ($fieldMap as $field => $variations) {
            foreach ($headings as $index => $heading) {
                $headingLower = strtolower(trim($heading));
                foreach ($variations as $variation) {
                    if ($headingLower === $variation || strpos($headingLower, $variation) !== false) {
                        $mapping[$field] = $index;
                        break 2;
                    }
                }
            }
        }

        return $mapping;
    }

    public function validateImportData(string $filePath, array $mappings, array $propertySelections = [], array $unitSelections = [], array $typeSelections = [])
    {
        $fullPath = Storage::path($filePath);
        $data = Excel::toArray([], $fullPath);
        $rows = array_slice($data[0], 1); // Skip header
        $headings = $data[0][0];

        $errors = [];
        $invoicesToCreate = [];
        $unmatchedProperties = [];
        $unmatchedUnits = [];
        $unmatchedTypes = [];
        $parentId = parentId();

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +2 because we start from row 2 (row 1 is header)

            // Map data
            $mappedData = [];
            foreach ($mappings as $field => $columnIndex) {
                if ($columnIndex !== 'ignore' && isset($row[$columnIndex])) {
                    $mappedData[$field] = trim($row[$columnIndex]);
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

            if (empty($mappedData['unit_name'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'unit_name',
                    'message' => __('Unit name is required.'),
                ];
                continue;
            }

            if (empty($mappedData['invoice_month'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'invoice_month',
                    'message' => __('Invoice month is required.'),
                ];
                continue;
            }

            if (empty($mappedData['end_date'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'end_date',
                    'message' => __('End date is required.'),
                ];
                continue;
            }

            if (empty($mappedData['invoice_type'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'invoice_type',
                    'message' => __('Invoice type is required.'),
                ];
                continue;
            }

            if (empty($mappedData['amount']) || !is_numeric($mappedData['amount']) || floatval($mappedData['amount']) <= 0) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'amount',
                    'message' => __('Valid amount is required.'),
                ];
                continue;
            }

            // Try to find property
            $property = null;
            $propertyKey = 'row_' . $rowNumber;
            
            if (!empty($propertySelections) && isset($propertySelections[$propertyKey]) && !empty($propertySelections[$propertyKey])) {
                $selectedPropertyId = (int)$propertySelections[$propertyKey];
                if ($selectedPropertyId > 0) {
                    $property = Property::where('id', $selectedPropertyId)
                        ->where('parent_id', $parentId)
                        ->first();
                }
            }
            
            if (!$property) {
                $property = $this->findPropertyByName($mappedData['property_name'], $parentId);
            }

            if (!$property) {
                $unmatchedProperties[$propertyKey] = [
                    'row' => $rowNumber,
                    'property_name' => $mappedData['property_name'],
                    'invoice_type' => $mappedData['invoice_type'] ?? '',
                    'amount' => $mappedData['amount'] ?? '',
                ];
                continue;
            }

            // Try to find unit
            $unit = null;
            
            if (!empty($unitSelections) && isset($unitSelections[$propertyKey]) && !empty($unitSelections[$propertyKey])) {
                $selectedUnitId = (int)$unitSelections[$propertyKey];
                if ($selectedUnitId > 0) {
                    $unit = PropertyUnit::where('id', $selectedUnitId)
                        ->where('property_id', $property->id)
                        ->where('parent_id', $parentId)
                        ->first();
                }
            }
            
            if (!$unit) {
                $unit = $this->findUnitByName($mappedData['unit_name'], $property->id, $parentId);
            }

            if (!$unit) {
                $unmatchedUnits[$propertyKey] = [
                    'row' => $rowNumber,
                    'property_id' => $property->id,
                    'property_name' => $property->name,
                    'unit_name' => $mappedData['unit_name'],
                    'invoice_type' => $mappedData['invoice_type'] ?? '',
                    'amount' => $mappedData['amount'] ?? '',
                ];
                continue;
            }

            // Try to find or create type
            $type = null;
            
            if (!empty($typeSelections) && isset($typeSelections[$propertyKey]) && !empty($typeSelections[$propertyKey])) {
                $selectedTypeId = (int)$typeSelections[$propertyKey];
                if ($selectedTypeId > 0) {
                    $type = Type::where('id', $selectedTypeId)
                        ->where('type', 'invoice')
                        ->where(function($query) use ($parentId) {
                            $query->where('parent_id', $parentId)
                                  ->orWhere('parent_id', 0);
                        })
                        ->first();
                }
            }
            
            if (!$type) {
                $type = $this->findTypeByName($mappedData['invoice_type'], 'invoice', $parentId);
            }

            // If type not found, create it
            if (!$type) {
                $type = new Type();
                $type->title = $mappedData['invoice_type'];
                $type->type = 'invoice';
                $type->parent_id = $parentId;
                $type->save();
            }

            // Validate date formats
            $invoiceMonth = $this->parseDate($mappedData['invoice_month'], true); // true = allow month-only format
            $endDate = $this->parseDate($mappedData['end_date'], false); // false = require full date

            if (!$invoiceMonth) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'invoice_month',
                    'message' => __('Invalid invoice month format. Supported formats: YYYY-MM, YYYY-MM-DD, DD/MM/YYYY, MM/DD/YYYY, etc.'),
                ];
                continue;
            }

            if (!$endDate) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'end_date',
                    'message' => __('Invalid end date format. Supported formats: YYYY-MM-DD, DD/MM/YYYY, MM/DD/YYYY, etc.'),
                ];
                continue;
            }

            // All validations passed
            $invoicesToCreate[] = [
                'row' => $rowNumber,
                'property_id' => $property->id,
                'unit_id' => $unit->id,
                'invoice_month' => $invoiceMonth,
                'end_date' => $endDate,
                'invoice_type_id' => $type->id,
                'amount' => floatval($mappedData['amount']),
                'invoice_id' => $mappedData['invoice_id'] ?? null,
                'notes' => $mappedData['notes'] ?? null,
                'description' => $mappedData['description'] ?? null,
            ];
        }

        return [
            'errors' => $errors,
            'invoices_to_create' => $invoicesToCreate,
            'unmatched_properties' => $unmatchedProperties,
            'unmatched_units' => $unmatchedUnits,
            'unmatched_types' => $unmatchedTypes,
            'total_rows' => count($rows),
        ];
    }

    public function executeImport(string $filePath, array $mappings, array $propertySelections = [], array $unitSelections = [], array $typeSelections = [])
    {
        $validation = $this->validateImportData($filePath, $mappings, $propertySelections, $unitSelections, $typeSelections);

        if (!empty($validation['errors'])) {
            throw new \Exception(__('Cannot import with validation errors.'));
        }

        if (!empty($validation['unmatched_properties']) || !empty($validation['unmatched_units'])) {
            throw new \Exception(__('Cannot import with unmatched properties or units.'));
        }

        $invoicesCreated = 0;
        $rowsSkipped = 0;
        $skipReasons = [];

        DB::beginTransaction();
        try {
            foreach ($validation['invoices_to_create'] as $invoiceData) {
                try {
                    // Generate invoice_id if not provided or extract numeric part from string
                    $invoiceIdValue = null;
                    if (!empty($invoiceData['invoice_id'])) {
                        // Extract numeric part from strings like 'INV-001' or '001'
                        $invoiceIdStr = trim($invoiceData['invoice_id']);
                        // Remove non-numeric characters and get the numeric part
                        preg_match('/\d+/', $invoiceIdStr, $matches);
                        if (!empty($matches)) {
                            $invoiceIdValue = (int)$matches[0];
                        }
                    }
                    
                    // If still empty or invalid, auto-generate
                    if (empty($invoiceIdValue) || $invoiceIdValue <= 0) {
                        $latest = Invoice::where('parent_id', parentId())->latest()->first();
                        $invoiceIdValue = $latest ? ($latest->invoice_id + 1) : 1;
                    }

                    // Create invoice
                    $invoice = new Invoice();
                    $invoice->invoice_id = $invoiceIdValue;
                    $invoice->property_id = $invoiceData['property_id'];
                    $invoice->unit_id = $invoiceData['unit_id'];
                    // Handle invoice_month: if it's YYYY-MM format, append '-01', otherwise use as-is
                    $invoiceMonth = $invoiceData['invoice_month'];
                    if (preg_match('/^\d{4}-\d{2}$/', $invoiceMonth)) {
                        $invoiceMonth .= '-01';
                    }
                    $invoice->invoice_month = $invoiceMonth;
                    $invoice->end_date = $invoiceData['end_date'];
                    $invoice->notes = $invoiceData['notes'];
                    $invoice->status = 'open';
                    $invoice->parent_id = parentId();
                    $invoice->save();

                    // Create invoice item
                    $invoiceItem = new InvoiceItem();
                    $invoiceItem->invoice_id = $invoice->id;
                    $invoiceItem->invoice_type = $invoiceData['invoice_type_id'];
                    $invoiceItem->amount = $invoiceData['amount'];
                    $invoiceItem->description = $invoiceData['description'];
                    $invoiceItem->save();

                    $invoicesCreated++;
                } catch (\Exception $e) {
                    $rowsSkipped++;
                    $skipReasons[] = [
                        'row' => $invoiceData['row'],
                        'reason' => $e->getMessage(),
                    ];
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return [
            'invoices_created' => $invoicesCreated,
            'rows_skipped' => $rowsSkipped,
            'skip_reasons' => $skipReasons,
        ];
    }

    private function findPropertyByName(string $name, int $parentId)
    {
        return Property::where('parent_id', $parentId)
            ->whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($name))])
            ->first();
    }

    private function findUnitByName(string $name, int $propertyId, int $parentId)
    {
        return PropertyUnit::where('property_id', $propertyId)
            ->where('parent_id', $parentId)
            ->whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($name))])
            ->first();
    }

    private function findTypeByName(string $name, string $type, int $parentId)
    {
        return Type::where('type', $type)
            ->where(function($query) use ($parentId) {
                $query->where('parent_id', $parentId)
                      ->orWhere('parent_id', 0);
            })
            ->whereRaw('LOWER(TRIM(title)) = ?', [strtolower(trim($name))])
            ->first();
    }

    private function parseDate($dateString, $allowMonthOnly = false)
    {
        if (empty($dateString)) {
            return null;
        }

        $dateString = trim($dateString);

        // Try YYYY-MM-DD format first
        $date = \DateTime::createFromFormat('Y-m-d', $dateString);
        if ($date && $date->format('Y-m-d') === $dateString) {
            return $date->format('Y-m-d');
        }

        // Try YYYY-MM format (only if allowed)
        if ($allowMonthOnly) {
            $date = \DateTime::createFromFormat('Y-m', $dateString);
            if ($date && $date->format('Y-m') === $dateString) {
                return $date->format('Y-m');
            }
        }

        // Try DD/MM/YYYY or MM/DD/YYYY formats
        $formats = [
            'd/m/Y', 'd-m-Y', 'd.m.Y',
            'm/d/Y', 'm-d-Y', 'm.d.Y',
            'Y/m/d', 'Y-m-d', 'Y.m.d',
            'd/m/y', 'd-m-y', 'd.m.y',
            'm/d/y', 'm-d-y', 'm.d.y',
            'd M Y', 'd M, Y', 'd F Y', 'd F, Y',
            'M d, Y', 'F d, Y',
            'Y M d', 'Y F d',
        ];

        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $dateString);
            if ($date) {
                // Verify the parsed date matches the input
                $formatted = $date->format($format);
                if ($formatted === $dateString || $this->datesMatch($formatted, $dateString, $format)) {
                    return $date->format('Y-m-d');
                }
            }
        }

        // Try Excel date serial number (if it's a numeric string)
        if (is_numeric($dateString) && strlen($dateString) > 5) {
            // Excel date serial numbers start from 1900-01-01
            $excelEpoch = new \DateTime('1899-12-30');
            $days = (int)$dateString;
            $excelEpoch->modify("+{$days} days");
            return $excelEpoch->format('Y-m-d');
        }

        // Last resort: use strtotime which can parse many formats
        $timestamp = strtotime($dateString);
        if ($timestamp !== false) {
            $parsedDate = date('Y-m-d', $timestamp);
            // Verify the parsed date is reasonable (not 1970-01-01 for invalid dates)
            if ($parsedDate >= '1970-01-01' && $parsedDate <= '2100-12-31') {
                return $parsedDate;
            }
        }

        return null;
    }

    private function datesMatch($formatted, $original, $format)
    {
        // Some formats might have slight differences (like leading zeros)
        // This is a helper to check if dates are essentially the same
        try {
            $date1 = \DateTime::createFromFormat($format, $formatted);
            $date2 = \DateTime::createFromFormat($format, $original);
            if ($date1 && $date2) {
                return $date1->format('Y-m-d') === $date2->format('Y-m-d');
            }
        } catch (\Exception $e) {
            // Ignore errors
        }
        return false;
    }
}

