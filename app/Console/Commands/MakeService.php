<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service
                            {name : Class name (e.g., UserService or JurnalService)}
                            {--extends= : The class to extend (override default base class)}
                            {--implements= : Interfaces to implement (comma separated)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Service class in app/Services/ by calling make:class and enforces the "Service" suffix.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name');

        if (!str_ends_with($name, 'Service')) {
            $this->error("Service class name must end with 'Service'. E.g., '{$name}Service'.");
            return self::FAILURE;
        }

        $extends = $this->option('extends');

        if (empty($extends)) {

            $extends = 'App\\Services\\Service';
        }

        $targetName = 'Services/' . $name;

        $arguments = [
            'name' => $targetName,
            '--extends' => $extends,
        ];

        $options = [];
        if ($implements = $this->option('implements')) {
            $options['--implements'] = $implements;
        }

        $callParameters = array_merge($arguments, $options);

        $this->info("Calling make:class to create '{$targetName}'...");
        $this->info("Extends: {$extends}");

        return $this->call('make:class', $callParameters);
    }
}
