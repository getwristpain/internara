<?php

namespace App\Console\Commands;

use App\Helpers\Debugger;
use App\Services\Console\LocationSyncService;
use Illuminate\Console\Command;

/**
 * ------------------------------------------------------------------------
 * LocationSyncCommand
 * ------------------------------------------------------------------------
 * Console command to synchronize Indonesian administrative regions into the `locations` table.
 */
class LocationSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:sync {--restore : Restore previous location data before syncing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Indonesian administrative regions into the locations table.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Starting location synchronization...');
        $startTime = microtime(true);

        try {
            app(LocationSyncService::class, [
                'command' => $this,
                'restore' => $this->option('restore')
            ])->syncAll();
        } catch (\Throwable $e) {
            $this->error('Synchronization failed: ' . $e->getMessage());
            Debugger::handle($e);
            return self::FAILURE;
        }

        $duration = round(microtime(true) - $startTime, 2);
        $this->info("[Duration: {$duration}s] Synchronization completed successfully.");
        return self::SUCCESS;
    }
}
