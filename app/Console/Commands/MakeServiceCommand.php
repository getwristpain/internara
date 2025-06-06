<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service class}
                            {--extends= : The parent class to extend, must end with "Service"}';

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
            $name = Str::camel($this->argument('name'));
            $extends = $this->option('extends');

            if (!Str::endsWith($name, 'Service')) {
                $this->error('The name must end with "Service"');
                return;
            }

            if ($extends) {
                if (!Str::endsWith($extends, 'Service')) {
                    $this->error('The --extends option must end with "Service"');
                    return;
                }
                $this->call('make:logic', [
                    'name' => "Services/{$name}",
                    '--extends' => $extends,
                ]);
            } else {
                $serviceClass = 'App\\Services\\Service';
                $this->call('make:logic', [
                    'name' => "Services/{$name}",
                    '--extends' => $serviceClass,
                ]);
            }
        } catch (\Throwable $th) {
            $this->error('Failed to create service class: '.$th->getMessage());
            exit(1);
        }
    }
}
