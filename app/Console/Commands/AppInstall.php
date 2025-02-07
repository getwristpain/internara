<?php

namespace App\Console\Commands;

use App\Debugger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AppInstall extends Command
{
    use Debugger;

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
    protected $description = 'Install the application.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->performInstall();
    }

    /**
     * Performs application installation.
     *
     * @return void
     */
    protected function performInstall(): void
    {
        try {
            $this->info('Starting the application installation ...');

            $this->setupEnvConfig();
            $this->clearCache();
            $this->connectDatabase();
            $this->runMigration();
            $this->runSeeder();
            $this->linkStorage();
            $this->cleanStorage();
            $this->buildApp();
            $this->optimizeApp();
            $this->makeOwner();

            $this->info('Successfully run the application installation.');
        } catch (\Throwable $th) {
            $this->handleError('An error occurs when running the application installation.', $th);
            throw $th;
        }
    }

    /**
     * Setup of the Application Environment Configuration.
     * TODO: Setup of the Application Environment Configuration.
     *
     * @return void
     */
    protected function setupEnvConfig(): void
    {
        try {
            $this->info('Startng to setup application environment configuration...');

            $this->checkAndCreateEnv();
            $this->generateAppKey();
            $this->configEnv();

            $this->info('Successfully set up the application environment.');
        } catch (\Throwable $th) {
            $this->handleError('Failed to setup application environment configuration.', $th);
            throw $th;
        }
    }

    /**
     * Check and create application environment.
     * TODO: Check and create application environment.
     *
     * @return void
     */
    protected function checkAndCreateEnv(): void
    {
        $this->info('Starting to check the application environment ...');

        if (!File::exists(base_path('.env'))) {
            $this->info('.env file does not exist, creating it...');

            if (File::exists(base_path('.env.example'))) {
                File::copy(base_path('.env.example'), base_path('.env'));
                $this->info('.env file has been created from .env.example.');
            } else {
                $this->handleError('.env.example file is missing! Please ensure the .env.example file is present.');
                return;
            }
        } else {
            $this->info('Skipped! .env file already exists.');
        }
    }

    /**
     * Handle an unexpected error.
     *
     * @param string $message
     * @param \Throwable|null $exception
     *
     * @return void
     */
    protected function handleError(string $message, ?\Throwable $exception = null): void
    {
        $this->error($this->debug('error', $message, $exception));
        exit(1);
    }
}
