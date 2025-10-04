<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeHelper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:helper
                            {name : Class name (e.g., Dates or ArrayUtils/Cleaner)}
                            {--extends= : The class to extend}
                            {--implements= : Interfaces to implement (comma separated)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Helper class in app/Helpers/ by calling make:class.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name');

        $targetName = 'Helpers/' . $name;

        $arguments = [
            'name' => $targetName,
        ];

        $extends = $this->option('extends');
        if (!empty($extends)) {
            $arguments['--extends'] = $extends;
        }

        $implements = $this->option('implements');
        if (!empty($implements)) {
            $arguments['--implements'] = $implements;
        }

        $this->info("Calling make:class to create '{$targetName}'...");

        return $this->call('make:class', $arguments);
    }
}
