<?php

namespace App\Console\Commands;

use App\Debugger;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class MakeService extends Command
{
    use Debugger;

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
            $message = $this->debug('error', "Failed to create service class: " . $th->getMessage(), $th);
            $this->error($message);
            exit(1);
        }
    }
}
