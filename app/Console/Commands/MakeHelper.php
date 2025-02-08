<?php

namespace App\Console\Commands;

use App\Debugger;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class MakeHelper extends Command
{
    use Debugger;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:helper {name : The name of the helper class}';

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
            $helperClass = 'App\\Helpers\\Helper';

            $name = Str::camel($this->argument('name'));
            $this->call('make:logic', ['name' => "Helpers/{$name}", '--extends' => $helperClass]);
        } catch (\Throwable $th) {
            $message = $this->debug('error', "Failed to create helper class: " . $th->getMessage(), $th);
            $this->error($message);
            exit(1);
        }
    }
}
