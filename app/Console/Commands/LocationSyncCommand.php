<?php

namespace App\Console\Commands;

use App\Helpers\Debugger;
use App\Services\Console\LocationSyncService;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

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
    public function handle(): void
    {
        $this->info('Starting location synchronization...');
        $start = microtime(true);

        $restore = $this->option('restore');

        try {
            app(LocationSyncService::class, ['command' => $this, 'restore' => $restore])
                ->syncAll();
        } catch (\Throwable $e) {
            $this->error('Sync failed: ' . $e->getMessage());

            Debugger::debug($e, 'LocationSync command error: ' . $e->getMessage(), throw: true);

            exit();
        }

        $end = microtime(true);
        $duration = round($end - $start, 2);

        $this->info("[{$duration}s] Location sync completed successfully.");
    }
}
