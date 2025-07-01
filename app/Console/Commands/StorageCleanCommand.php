<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Debugger;
use App\Services\Console\StorageCleanService;

/**
 * ------------------------------------------------------------------------
 * StorageCleanCommand
 * ------------------------------------------------------------------------
 * Console command to clean temporary and cached files from the storage.
 */
class StorageCleanCommand extends Command
{
    /**
     * The signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:clean';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Clean temporary and cached files from the storage.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Starting to clean up storage...');
        $this->newLine();

        $startTime = microtime(true);

        try {
            app(StorageCleanService::class, ['command' => $this])->run();
        } catch (\Throwable $th) {
            $this->error('Failed to clean the storage.');
            Debugger::handle($th);
            return self::FAILURE;
        }

        $duration = round(microtime(true) - $startTime, 2);

        $this->newLine();
        $this->info("[Duration: {$duration}s] Storage cleaned successfully.");
        return self::SUCCESS;
    }
}
