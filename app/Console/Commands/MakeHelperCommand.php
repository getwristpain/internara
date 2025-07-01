<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Helpers\Debugger;

/**
 * ------------------------------------------------------------------------
 * Make Helper Command
 * ------------------------------------------------------------------------
 * Generate a new helper class under App\Helpers with optional base class.
 */
class MakeHelperCommand extends Command
{
    /**
     * ------------------------------------------------------------------------
     * Command Signature
     * ------------------------------------------------------------------------
     * Defines CLI signature with name and optional --extends.
     *
     * @var string
     */
    protected $signature = 'make:helper
        {name : The name of the helper class}
        {--extends= : The parent class to extend (must end with "Helper")}';

    /**
     * ------------------------------------------------------------------------
     * Command Description
     * ------------------------------------------------------------------------
     * Description shown in Artisan list.
     *
     * @var string
     */
    protected $description = 'Generate a new helper class inside the App\\Helpers namespace.';

    /**
     * ------------------------------------------------------------------------
     * Handle Command Execution
     * ------------------------------------------------------------------------
     * Process input and dispatch to make:logic with namespace.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $name = Str::studly($this->argument('name'));
            $extends = $this->option('extends');

            if (!Str::endsWith($name, 'Helper')) {
                $this->error('The name must end with "Helper".');
                return static::FAILURE;
            }

            if ($extends && !Str::endsWith($extends, 'Helper')) {
                $this->error('The --extends option must end with "Helper".');
                return static::FAILURE;
            }

            $this->call('make:logic', [
                'name' => "Helpers/{$name}",
                '--extends' => $extends ?: 'App\\Helpers\\Helper',
            ]);

            return static::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Failed to create helper class: ' . $e->getMessage());

            Debugger::handle(
                exception: $e,
                properties: [
                    'context' => [
                        'name' => $this->argument('name'),
                        'extends' => $this->option('extends'),
                    ]
                ],
            );

            return static::FAILURE;
        }
    }
}
