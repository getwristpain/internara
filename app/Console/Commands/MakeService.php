<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new service class inside the App\Services namespace.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $serviceClass = 'App\\Services\\Service';

            $name = Str::camel($this->argument('name'));
            $this->call('make:logic', ['name' => "Services/{$name}", '--extends' => $serviceClass]);
        } catch (\Throwable $th) {
            $this->error('Failed to create service class: '.$th->getMessage());
            exit(1);
        }
    }
}
