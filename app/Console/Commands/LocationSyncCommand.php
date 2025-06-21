<?php

namespace App\Console\Commands;

use App\Helpers\Debugger;
use App\Services\Console\LocationSyncService;
use Illuminate\Console\Command;

class LocationSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:sync {--restore : Restore locations backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and sync location data from wilayah.id into the locations table';

    /**
     * Execute the console command.
     */
    public function handle(): bool
    {
        $this->info('Starting location synchronization...');
        $startTime = microtime(true);

        $restore = $this->option('restore');

        try {
            app(LocationSyncService::class, ['command' => $this, 'restore' => $restore])
                ->syncAll();
        } catch (\Throwable $e) {
            $this->error('Sync failed: ' . $e->getMessage());

            Debugger::debug($e, 'LocationSync command error: ' . $e->getMessage(), throw: true);

            return static::FAILURE;
        }

        $endTime = microtime(true);
        $duration = round($endTime - $startTime, 2);

        $this->info("[Duration: {$duration}s] Location sync completed successfully.");

        return static::SUCCESS;
    }
}
