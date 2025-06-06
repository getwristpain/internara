<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeHelperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:helper {name : The name of the helper class}
                            {--extends= : The parent class to extend, must end with "Helper"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new helper class inside the App\Helpers namespace.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = Str::camel($this->argument('name'));
            $extends = $this->option('extends');

            if ($extends) {
                $this->call('make:logic', [
                    'name' => "Helpers/{$name}",
                    '--extends' => $extends,
                ]);
            } else {
                $helperClass = 'App\\Helpers\\Helper';
                $this->call('make:logic', [
                    'name' => "Helpers/{$name}",
                    '--extends' => $helperClass,
                ]);
            }
        } catch (\Throwable $th) {
            $this->error('Failed to create helper class: '.$th->getMessage());
            exit(1);
        }
    }
}
