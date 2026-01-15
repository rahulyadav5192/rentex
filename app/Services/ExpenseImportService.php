<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseImportService
{
    public function getExpenseFields()
    {
        return [
            'required' => [
                'property_name' => ['label' => __('Property Name'), 'type' => 'text', 'description' => __('Name of the property (must match existing property)')],
                'unit_name' => ['label' => __('Unit Name'), 'type' => 'text', 'description' => __('Name of the unit (must match existing unit)')],
                'expense_type' => ['label' => __('Expense Type'), 'type' => 'text', 'description' => __('Type name (will be created if not exists)')],
                'amount' => ['label' => __('Amount'), 'type' => 'number', 'description' => __('Numeric value, e.g., 1000.50')],
                'date' => ['label' => __('Date'), 'type' => 'date', 'description' => __('Format: YYYY-MM-DD')],
                'title' => ['label' => __('Title'), 'type' => 'text', 'description' => __('Expense title/description')],
            ],
            'optional' => [
                'expense_id' => ['label' => __('Expense Number'), 'type' => 'text', 'description' => __('Expense number (auto-generated if not provided)')],
                'notes' => ['label' => __('Notes'), 'type' => 'text', 'description' => __('Additional notes for the expense')],
            ]
        ];
    }

    public function getSampleData()
    {
        return [
            ['Property A', 'Unit 101', 'Maintenance', '500.00', '2024-01-15', 'Monthly maintenance', 'EXP-001', 'Regular maintenance'],
            ['Property A', 'Unit 102', 'Repair', '300.00', '2024-01-20', 'Plumbing repair', 'EXP-002', ''],
            ['Property B', 'Unit 201', 'Utilities', '200.00', '2024-01-10', 'Electricity bill', '', ''],
        ];
    }

    public function autoMapFields(array $headings)
    {
        $mapping = [];
        $fieldMap = [
            'property_name' => ['property', 'property name', 'property_name'],
            'unit_name' => ['unit', 'unit name', 'unit_name'],
            'expense_type' => ['type', 'expense type', 'expense_type', 'category'],
            'amount' => ['amount', 'price', 'cost', 'total'],
            'expense_id' => ['expense id', 'expense_id', 'expense number', 'expense_number', 'id'],
            'title' => ['title', 'name', 'expense title', 'expense_title'],
            'date' => ['date', 'expense date', 'expense_date'],
            'notes' => ['notes', 'note', 'comment', 'comments'],
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
        $expensesToCreate = [];
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

            if (empty($mappedData['expense_type'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'expense_type',
                    'message' => __('Expense type is required.'),
                ];
                continue;
            }

            if (empty($mappedData['title'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'title',
                    'message' => __('Title is required.'),
                ];
                continue;
            }

            if (empty($mappedData['date'])) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'date',
                    'message' => __('Date is required.'),
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
                        ->where('type', 'expense')
                        ->where(function($query) use ($parentId) {
                            $query->where('parent_id', $parentId)
                                  ->orWhere('parent_id', 0);
                        })
                        ->first();
                }
            }
            
            if (!$type) {
                $type = $this->findTypeByName($mappedData['expense_type'], 'expense', $parentId);
            }

            // If type not found, create it
            if (!$type) {
                $type = new Type();
                $type->title = $mappedData['expense_type'];
                $type->type = 'expense';
                $type->parent_id = $parentId;
                $type->save();
            }

            // Validate date format
            $date = $this->parseDate($mappedData['date']);

            if (!$date) {
                $errors[] = [
                    'row' => $rowNumber,
                    'field' => 'date',
                    'message' => __('Invalid date format. Use YYYY-MM-DD'),
                ];
                continue;
            }

            // All validations passed
            $expensesToCreate[] = [
                'row' => $rowNumber,
                'property_id' => $property->id,
                'unit_id' => $unit->id,
                'date' => $date,
                'expense_type_id' => $type->id,
                'amount' => floatval($mappedData['amount']),
                'title' => $mappedData['title'],
                'expense_id' => $mappedData['expense_id'] ?? null,
                'notes' => $mappedData['notes'] ?? null,
            ];
        }

        return [
            'errors' => $errors,
            'expenses_to_create' => $expensesToCreate,
            'unmatched_properties' => $unmatchedProperties,
            'unmatched_units' => $unmatchedUnits,
            'unmatched_types' => $unmatchedTypes,
            'total_rows' => count($rows),
        ];
    }

    public function executeImport(string $filePath, array $mappings)
    {
        $validation = $this->validateImportData($filePath, $mappings);

        if (!empty($validation['errors'])) {
            throw new \Exception(__('Cannot import with validation errors.'));
        }

        if (!empty($validation['unmatched_properties']) || !empty($validation['unmatched_units'])) {
            throw new \Exception(__('Cannot import with unmatched properties or units.'));
        }

        $expensesCreated = 0;
        $rowsSkipped = 0;
        $skipReasons = [];

        DB::beginTransaction();
        try {
            foreach ($validation['expenses_to_create'] as $expenseData) {
                try {
                    // Generate expense_id if not provided
                    if (empty($expenseData['expense_id'])) {
                        $latest = Expense::where('parent_id', parentId())->latest()->first();
                        $expenseData['expense_id'] = $latest ? ($latest->expense_id + 1) : 1;
                    }

                    // Create expense
                    $expense = new Expense();
                    $expense->expense_id = $expenseData['expense_id'];
                    $expense->property_id = $expenseData['property_id'];
                    $expense->unit_id = $expenseData['unit_id'];
                    $expense->date = $expenseData['date'];
                    $expense->expense_type = $expenseData['expense_type_id'];
                    $expense->amount = $expenseData['amount'];
                    $expense->title = $expenseData['title'];
                    $expense->notes = $expenseData['notes'];
                    $expense->parent_id = parentId();
                    $expense->save();

                    $expensesCreated++;
                } catch (\Exception $e) {
                    $rowsSkipped++;
                    $skipReasons[] = [
                        'row' => $expenseData['row'],
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
            'expenses_created' => $expensesCreated,
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

    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        // Try YYYY-MM-DD format
        $date = \DateTime::createFromFormat('Y-m-d', $dateString);
        if ($date) {
            return $date->format('Y-m-d');
        }

        // Try YYYY-MM format
        $date = \DateTime::createFromFormat('Y-m', $dateString);
        if ($date) {
            return $date->format('Y-m');
        }

        // Try other common formats
        $timestamp = strtotime($dateString);
        if ($timestamp !== false) {
            return date('Y-m-d', $timestamp);
        }

        return null;
    }
}

