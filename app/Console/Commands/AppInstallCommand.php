<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Console\AppInstallService;

class AppInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automates the installation and setup of the application, including environment configuration, database setup, migrations, and optimizations.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $appUrl = config('app.url', 'http://localhost:8000');

        $this->info('Starting installation...');

        app(AppInstallService::class, ['command' => $this])->install();

        $this->info('Installation completed.');
        $this->info("\nRun 'php artisan serve' to start the server.");
        $this->info("Open $appUrl in your browser.");
    }
}
