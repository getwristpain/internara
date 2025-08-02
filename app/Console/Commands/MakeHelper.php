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
    protected $signature = 'make:helper {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Helper class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = 'Helpers/' . trim($this->argument('name'));
        $this->call('make:logic', ['name' => $name, '--extends' => 'App\\Helpers\\Helper']);
    }
}
