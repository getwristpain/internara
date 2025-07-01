<?php

namespace App\Services\Console;

use App\Helpers\Debugger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * ------------------------------------------------------------------------
 * StorageCleanService
 * ------------------------------------------------------------------------
 * Service to clean temporary and cached files from storage directories.
 */
class StorageCleanService extends CommandService
{
    /**
     * Constructor for StorageCleanService.
     *
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        parent::__construct($command);
    }

    /**
     * Execute the storage cleanup process.
     *
     * @return void
     */
    public function run(): void
    {
        $folders = [
            'app/private/cache',
            'app/private/livewire-tmp',
            'app/public/uploads',
            'debugbar',
            'framework/cache/data',
            'framework/livewire-temp',
            'framework/sessions',
            'framework/testing',
            'framework/views',
            'logs',
        ];

        try {
            foreach ($folders as $folder) {
                $directory = storage_path($folder);

                if (!File::exists($directory)) {
                    continue;
                }

                $this->command->info("Cleaning: {$folder}");

                if (!File::cleanDirectory($directory)) {
                    $this->command->warn("Failed to clean or access: {$folder}");
                }
            }
        } catch (\Throwable $th) {
            $this->command->error('An error occurred while cleaning the storage.');
            Debugger::handle($th);
        }
    }
}
