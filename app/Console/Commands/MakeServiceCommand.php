<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Helpers\Debugger;

/**
 * ------------------------------------------------------------------------
 * Make Service Command
 * ------------------------------------------------------------------------
 * Generate a new service class under App\Services with optional base class.
 */
class MakeServiceCommand extends Command
{
    /**
     * ------------------------------------------------------------------------
     * Command Signature
     * ------------------------------------------------------------------------
     * CLI signature with argument and optional `--extends`.
     *
     * @var string
     */
    protected $signature = 'make:service
        {name : The name of the service class}
        {--extends= : The parent class to extend (must end with "Service")}';

    /**
     * ------------------------------------------------------------------------
     * Command Description
     * ------------------------------------------------------------------------
     * Description for Artisan list.
     *
     * @var string
     */
    protected $description = 'Generate a new service class inside the App\\Services namespace.';

    /**
     * ------------------------------------------------------------------------
     * Handle Command
     * ------------------------------------------------------------------------
     * Execute the Artisan command and dispatch to make:logic.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $name = Str::studly($this->argument('name'));
            $extends = $this->option('extends');

            if (!Str::endsWith($name, 'Service')) {
                $this->error('The name must end with "Service".');
                return static::FAILURE;
            }

            if ($extends && !Str::endsWith($extends, 'Service')) {
                $this->error('The --extends option must end with "Service".');
                return static::FAILURE;
            }

            $this->call('make:logic', [
                'name' => "Services/{$name}",
                '--extends' => $extends ?: 'App\\Services\\Service',
            ]);

            return static::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Failed to create service class: ' . $e->getMessage());

            Debugger::handle(
                exception: $e,
                properties: [
                    'context' => [
                        'name' => $this->argument('name'),
                        'extends' => $this->option('extends'),
                    ],
                ],
            );

            return static::FAILURE;
        }
    }
}
