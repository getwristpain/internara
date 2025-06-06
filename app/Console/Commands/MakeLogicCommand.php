<?php

namespace App\Console\Commands;

use App\Helpers\Debugger;
use Illuminate\Console\Command;
use App\Services\Console\MakeLogicService;

class MakeLogicCommand extends Command
{
    protected $signature = 'make:logic {name : The folder/class name in format Folder/ClassName}
                            {--extends= : The class to extend from (e.g., App\\Helpers\\Formatter, Illuminate\\Console\\Command)}';

    protected $description = 'Create a new utility class with a dynamic namespace inside app directory';

    public function handle(): void
    {
        $service = app(MakeLogicService::class);

        $name = $this->argument('name');
        $extends = $this->option('extends');

        try {
            $filePath = $service->make($name, $extends);
            $this->info("Class created successfully at $filePath");
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            Debugger::debug($e, 'Failed to create logic class.', [
                'name' => $name,
                'extends' => $extends,
            ]);
        }
    }
}
