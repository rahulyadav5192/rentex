<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceGenerationLog;
use App\Models\InvoiceItem;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\Tenant;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutoInvoiceService
{
    /**
     * Generate invoices for all eligible units
     * 
     * @param int $parentId
     * @param Carbon|null $targetMonth If null, uses current month
     * @param bool $dryRun If true, only previews without creating invoices
     * @return array
     */
    public function generateInvoices(int $parentId, ?Carbon $targetMonth = null, bool $dryRun = false): array
    {
        if ($targetMonth === null) {
            $targetMonth = Carbon::now();
        }

        $targetYear = $targetMonth->year;
        $targetMonthNum = $targetMonth->month;
        $targetMonthStart = Carbon::create($targetYear, $targetMonthNum, 1)->startOfDay();
        $targetMonthEnd = $targetMonthStart->copy()->endOfMonth();

        $invoicesCreated = 0;
        $invoicesFailed = 0;
        $errors = [];
        $createdDetails = [];
        $failedDetails = [];
        $skippedDetails = []; // For preview mode - show why units were skipped

        // Get all properties with auto-invoice enabled
        $properties = Property::where('parent_id', $parentId)
            ->where('auto_invoice_enabled', true)
            ->where('is_active', true)
            ->get();

        // If no properties found, check what's missing
        if ($properties->isEmpty() && $dryRun) {
            $allProperties = Property::where('parent_id', $parentId)->get();
            $enabledProperties = Property::where('parent_id', $parentId)->where('auto_invoice_enabled', true)->get();
            
            if ($allProperties->isEmpty()) {
                $errors[] = 'No properties found for this account.';
            } elseif ($enabledProperties->isEmpty()) {
                $errors[] = 'No properties have auto-invoice enabled. Found ' . $allProperties->count() . ' properties, but none are enabled for auto-invoice.';
            }
        }

        foreach ($properties as $property) {
            // Get all units for this property that have auto-invoice enabled
            $units = PropertyUnit::where('property_id', $property->id)
                ->where('parent_id', $parentId)
                ->where('auto_invoice_enabled', true)
                ->where('is_occupied', true)
                ->where('rent', '>', 0)
                ->get();

            // Get all units for this property (for debugging in preview mode)
            $allPropertyUnits = PropertyUnit::where('property_id', $property->id)
                ->where('parent_id', $parentId)
                ->get();

            if ($allPropertyUnits->isEmpty() && $dryRun) {
                $skippedDetails[] = [
                    'property_name' => $property->name,
                    'reason' => 'No units found for this property',
                ];
            }

            foreach ($units as $unit) {
                try {
                    // Check if invoice already exists for this month/unit
                    $existingInvoice = Invoice::where('parent_id', $parentId)
                        ->where('unit_id', $unit->id)
                        ->whereYear('invoice_month', $targetYear)
                        ->whereMonth('invoice_month', $targetMonthNum)
                        ->first();

                    if ($existingInvoice) {
                        if ($dryRun) {
                            $skippedDetails[] = [
                                'property_name' => $property->name,
                                'unit_name' => $unit->name,
                                'reason' => 'Invoice already exists for ' . $targetMonth->format('F Y'),
                            ];
                        }
                        continue; // Skip if invoice already exists
                    }

                    // Get tenant for this unit
                    $tenant = Tenant::where('unit', $unit->id)
                        ->where('parent_id', $parentId)
                        ->first();

                    if (!$tenant) {
                        if ($dryRun) {
                            $skippedDetails[] = [
                                'property_name' => $property->name,
                                'unit_name' => $unit->name,
                                'reason' => 'No active tenant found',
                            ];
                        }
                        continue; // Skip silently, don't count as error
                    }

                    // Check lease dates
                    if ($tenant->lease_start_date) {
                        $leaseStart = Carbon::parse($tenant->lease_start_date);
                        if ($targetMonthEnd->lt($leaseStart)) {
                            if ($dryRun) {
                                $skippedDetails[] = [
                                    'property_name' => $property->name,
                                    'unit_name' => $unit->name,
                                    'reason' => 'Lease starts on ' . dateFormat($tenant->lease_start_date) . ' (after target month)',
                                ];
                            }
                            continue; // Lease hasn't started yet
                        }
                    }

                    if ($tenant->lease_end_date) {
                        $leaseEnd = Carbon::parse($tenant->lease_end_date);
                        if ($targetMonthStart->gt($leaseEnd)) {
                            if ($dryRun) {
                                $skippedDetails[] = [
                                    'property_name' => $property->name,
                                    'unit_name' => $unit->name,
                                    'reason' => 'Lease ended on ' . dateFormat($tenant->lease_end_date) . ' (before target month)',
                                ];
                            }
                            continue; // Lease has ended
                        }
                    }

                    // Calculate prorated amount if needed
                    $rentAmount = $this->calculateProratedRent($unit, $tenant, $targetMonthStart, $targetMonthEnd);

                    if ($rentAmount <= 0) {
                        if ($dryRun) {
                            $skippedDetails[] = [
                                'property_name' => $property->name,
                                'unit_name' => $unit->name,
                                'reason' => 'Calculated rent amount is 0 or negative',
                            ];
                        }
                        continue; // Skip if no rent amount
                    }

                    if (!$dryRun) {
                        // Get or create invoice type
                        $invoiceType = $this->getOrCreateInvoiceType($unit, $parentId);

                        // Generate invoice ID
                        $invoiceId = $this->generateInvoiceId($parentId);

                        // Create invoice
                        $invoice = new Invoice();
                        $invoice->invoice_id = $invoiceId;
                        $invoice->property_id = $property->id;
                        $invoice->unit_id = $unit->id;
                        $invoice->invoice_month = $targetMonthStart->format('Y-m-d');
                        $invoice->end_date = $unit->payment_due_date ?? $targetMonthEnd->format('Y-m-d');
                        $invoice->notes = __('Auto-generated invoice for :month', ['month' => $targetMonthStart->format('F Y')]);
                        $invoice->status = 'open';
                        $invoice->parent_id = $parentId;
                        $invoice->save();

                        // Create invoice item
                        $invoiceItem = new InvoiceItem();
                        $invoiceItem->invoice_id = $invoice->id;
                        $invoiceItem->invoice_type = $invoiceType->id;
                        $invoiceItem->amount = $rentAmount;
                        $invoiceItem->description = __('Monthly rent for :month', ['month' => $targetMonthStart->format('F Y')]);
                        $invoiceItem->save();

                        // Update unit's last generated timestamp
                        $unit->last_invoice_generated_at = Carbon::now();
                        $unit->save();

                        $invoicesCreated++;
                        $createdDetails[] = [
                            'invoice_id' => $invoice->id,
                            'unit_id' => $unit->id,
                            'unit_name' => $unit->name,
                            'property_name' => $property->name,
                            'amount' => $rentAmount,
                            'invoice_month' => $targetMonthStart->format('Y-m-d'),
                        ];
                    } else {
                        // Dry run - just count
                        $invoicesCreated++;
                        $createdDetails[] = [
                            'unit_id' => $unit->id,
                            'unit_name' => $unit->name,
                            'property_name' => $property->name,
                            'amount' => $rentAmount,
                            'invoice_month' => $targetMonthStart->format('Y-m-d'),
                        ];
                    }
                } catch (\Exception $e) {
                    $invoicesFailed++;
                    $errorMsg = "Unit {$unit->name} (ID: {$unit->id}): " . $e->getMessage();
                    $errors[] = $errorMsg;
                    $failedDetails[] = [
                        'unit_id' => $unit->id,
                        'unit_name' => $unit->name,
                        'property_name' => $property->name,
                        'reason' => $e->getMessage(),
                    ];
                    Log::error('Auto Invoice Generation Error', [
                        'unit_id' => $unit->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }
        }

        $status = 'success';
        if ($invoicesFailed > 0 && $invoicesCreated > 0) {
            $status = 'partial';
        } elseif ($invoicesFailed > 0 && $invoicesCreated == 0) {
            $status = 'failed';
        }

        // Log the generation
        if (!$dryRun) {
            $log = new InvoiceGenerationLog();
            $log->parent_id = $parentId;
            $log->generation_date = $targetMonthStart;
            $log->invoices_created = $invoicesCreated;
            $log->invoices_failed = $invoicesFailed;
            $log->status = $status;
            $log->error_log = !empty($errors) ? implode("\n", $errors) : null;
            $log->details = [
                'created' => $createdDetails,
                'failed' => $failedDetails,
            ];
            $log->save();
        }

        $result = [
            'invoices_created' => $invoicesCreated,
            'invoices_failed' => $invoicesFailed,
            'status' => $status,
            'errors' => $errors,
            'created_details' => $createdDetails,
            'failed_details' => $failedDetails,
        ];

        // Add skipped details for preview mode
        if ($dryRun && !empty($skippedDetails)) {
            $result['skipped_details'] = $skippedDetails;
        }

        // Add summary info for preview mode
        if ($dryRun) {
            $result['summary'] = [
                'properties_checked' => Property::where('parent_id', $parentId)->count(),
                'properties_enabled' => Property::where('parent_id', $parentId)->where('auto_invoice_enabled', true)->count(),
                'total_units' => PropertyUnit::where('parent_id', $parentId)
                    ->whereIn('property_id', Property::where('parent_id', $parentId)->where('auto_invoice_enabled', true)->pluck('id'))
                    ->count(),
                'eligible_units' => PropertyUnit::where('parent_id', $parentId)
                    ->whereIn('property_id', Property::where('parent_id', $parentId)->where('auto_invoice_enabled', true)->pluck('id'))
                    ->where('auto_invoice_enabled', true)
                    ->where('is_occupied', true)
                    ->where('rent', '>', 0)
                    ->count(),
            ];
        }

        return $result;
    }

    /**
     * Calculate prorated rent amount based on lease dates
     */
    private function calculateProratedRent(PropertyUnit $unit, Tenant $tenant, Carbon $monthStart, Carbon $monthEnd): float
    {
        $rentAmount = (float) $unit->rent;
        $daysInMonth = $monthEnd->day;
        $occupiedDays = $daysInMonth;

        // Adjust for lease start date
        if ($tenant->lease_start_date) {
            $leaseStart = Carbon::parse($tenant->lease_start_date);
            if ($leaseStart->gt($monthStart)) {
                $occupiedDays = $monthEnd->diffInDays($leaseStart) + 1;
            }
        }

        // Adjust for lease end date
        if ($tenant->lease_end_date) {
            $leaseEnd = Carbon::parse($tenant->lease_end_date);
            if ($leaseEnd->lt($monthEnd)) {
                $occupiedDays = $leaseEnd->diffInDays($monthStart) + 1;
            }
        }

        // If both dates are within the month, calculate the overlap
        if ($tenant->lease_start_date && $tenant->lease_end_date) {
            $leaseStart = Carbon::parse($tenant->lease_start_date);
            $leaseEnd = Carbon::parse($tenant->lease_end_date);
            
            $actualStart = $leaseStart->gt($monthStart) ? $leaseStart : $monthStart;
            $actualEnd = $leaseEnd->lt($monthEnd) ? $leaseEnd : $monthEnd;
            
            if ($actualStart->lte($actualEnd)) {
                $occupiedDays = $actualStart->diffInDays($actualEnd) + 1;
            } else {
                $occupiedDays = 0;
            }
        }

        // Calculate prorated amount
        if ($occupiedDays < $daysInMonth && $occupiedDays > 0) {
            $rentAmount = ($rentAmount / $daysInMonth) * $occupiedDays;
        }

        return round($rentAmount, 2);
    }

    /**
     * Get or create invoice type for the unit
     */
    private function getOrCreateInvoiceType(PropertyUnit $unit, int $parentId): Type
    {
        // If unit has a default invoice type, use it
        if ($unit->default_invoice_type_id) {
            $type = Type::where('id', $unit->default_invoice_type_id)
                ->where('parent_id', $parentId)
                ->where('type', 'invoice')
                ->first();
            
            if ($type) {
                return $type;
            }
        }

        // Try to find "Rent" type
        $type = Type::where('type', 'invoice')
            ->where(function($query) use ($parentId) {
                $query->where('parent_id', $parentId)
                      ->orWhere('parent_id', 0);
            })
            ->whereRaw('LOWER(TRIM(title)) = ?', [strtolower(trim('Rent'))])
            ->first();

        if ($type) {
            return $type;
        }

        // Create new "Rent" type
        $type = new Type();
        $type->title = 'Rent';
        $type->type = 'invoice';
        $type->parent_id = $parentId;
        $type->save();

        return $type;
    }

    /**
     * Generate next invoice ID
     */
    private function generateInvoiceId(int $parentId): int
    {
        $latest = Invoice::where('parent_id', $parentId)
            ->orderBy('invoice_id', 'desc')
            ->first();

        return $latest ? ($latest->invoice_id + 1) : 1;
    }

    /**
     * Preview invoices that would be generated
     */
    public function previewInvoices(int $parentId, ?Carbon $targetMonth = null): array
    {
        return $this->generateInvoices($parentId, $targetMonth, true);
    }
}

