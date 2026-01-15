<?php

namespace App\Console\Commands;

use App\Services\AutoInvoiceService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateMonthlyInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:generate-monthly {--month=} {--parent-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly rent invoices automatically for all eligible units';

    protected $autoInvoiceService;

    public function __construct(AutoInvoiceService $autoInvoiceService)
    {
        parent::__construct();
        $this->autoInvoiceService = $autoInvoiceService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting automatic invoice generation...');

        // Determine target month
        $monthOption = $this->option('month');
        if ($monthOption) {
            try {
                $targetMonth = Carbon::parse($monthOption);
            } catch (\Exception $e) {
                $this->error("Invalid month format: {$monthOption}. Use YYYY-MM format.");
                return Command::FAILURE;
            }
        } else {
            $targetMonth = Carbon::now();
        }

        $this->info("Target month: {$targetMonth->format('F Y')}");

        // Get parent IDs to process
        $parentIdOption = $this->option('parent-id');
        if ($parentIdOption) {
            $parentIds = [(int) $parentIdOption];
        } else {
            // Get all unique parent IDs from properties with auto-invoice enabled
            $parentIds = \App\Models\Property::where('auto_invoice_enabled', true)
                ->distinct()
                ->pluck('parent_id')
                ->toArray();
        }

        if (empty($parentIds)) {
            $this->warn('No properties found with auto-invoice enabled.');
            return Command::SUCCESS;
        }

        $totalCreated = 0;
        $totalFailed = 0;

        foreach ($parentIds as $parentId) {
            $this->info("Processing parent ID: {$parentId}");

            try {
                $result = $this->autoInvoiceService->generateInvoices($parentId, $targetMonth, false);

                $totalCreated += $result['invoices_created'];
                $totalFailed += $result['invoices_failed'];

                $this->info("  Created: {$result['invoices_created']}, Failed: {$result['invoices_failed']}");

                if (!empty($result['errors'])) {
                    foreach ($result['errors'] as $error) {
                        $this->warn("  Error: {$error}");
                    }
                }
            } catch (\Exception $e) {
                $this->error("Error processing parent ID {$parentId}: " . $e->getMessage());
                Log::error('Invoice generation command error', [
                    'parent_id' => $parentId,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        $this->info("Generation complete. Total created: {$totalCreated}, Total failed: {$totalFailed}");

        return Command::SUCCESS;
    }
}
