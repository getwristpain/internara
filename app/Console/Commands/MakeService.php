<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use InvalidArgumentException;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = 'Services/' . trim($this->argument('name'));

        if (!str_ends_with($name, 'Service')) {
            throw new InvalidArgumentException("The name '{$name}' must be end with 'Service'");
        }

        $this->call('make:logic', ['name' => $name, '--extends' => 'App\\Services\\Service']);
    }
}
