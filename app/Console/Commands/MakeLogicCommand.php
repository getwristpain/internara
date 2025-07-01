<?php

namespace App\Console\Commands;

use App\Helpers\Debugger;
use Illuminate\Console\Command;
use App\Services\Console\MakeLogicService;

/**
 * CLI command to generate a logic utility class with dynamic namespace.
 */
class MakeLogicCommand extends Command
{
    /** @var string */
    protected $signature = 'make:logic
        {name : The folder/class name in format Folder/ClassName}
        {--extends= : The class to extend from (e.g., App\\Helpers\\Formatter, Illuminate\\Console\\Command)}';

    /** @var string */
    protected $description = 'Create a new utility class with a dynamic namespace inside app directory';

    /**
     * Execute the command.
     */
    public function handle(): void
    {
        $service = app(MakeLogicService::class);

        $name = $this->argument('name');
        $extends = $this->option('extends');

        try {
            $filePath = $service->make($name, $extends);
            $this->info("Class created successfully at: {$filePath}");
        } catch (\Throwable $e) {
            $this->error($e->getMessage());

            Debugger::handle(
                exception: $e,
                properties: [
                    'name' => $name,
                    'extends' => $extends,
                    'command' => 'make:logic',
                ],
                throw: false
            );
        }
    }
}
