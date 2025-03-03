<?php

namespace App\Console\Commands;

use App\Debugger;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

use function Laravel\Prompts\{text, confirm, password, select};

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
    protected $description = 'Automates the installation and setup of the application, including environment configuration, database setup, migrations, and optimizations.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $appUrl = config('app.url', 'localhost:8000');

        $this->info('Starting installation...');

        $this->install();

        $this->info('Installation completed.');
        $this->info("\nRun 'php artisan serve' to start the server.");
        $this->info("Open $appUrl in your browser.");
    }

    /**
     * Perform the installation steps.
     */
    protected function install()
    {
        $this->clearCache();
        $this->checkEnvFile();
        $this->generateAppKey();
        $this->configureEnv();
        $this->configureDatabase();
        $this->runMigrations();
        $this->runFreshMigrations();
        $this->seedDatabase();
        $this->createStorageLink();
        $this->cleanStorage();
        $this->buildAssets();
        $this->optimize();
    }

    /**
     * Clear the application cache.
     */
    protected function clearCache()
    {
        $this->executeCommand('optimize:clear', [], 'Clearing cache...', 'Cache cleared.', 'Failed to clear cache.');
    }

    /**
     * Check and create the .env file if it does not exist.
     */
    protected function checkEnvFile()
    {
        $this->info('Checking environment file...');

        if (!File::exists(base_path('.env'))) {
            $this->info('.env file does not exist, creating it...');

            if (File::exists(base_path('.env.example'))) {
                File::copy(base_path('.env.example'), base_path('.env'));
                $this->info('.env file created from .env.example.');
            } else {
                $this->abort('Missing .env.example file! Please ensure the .env.example file is present.');
            }
        } else {
            $this->info('Skipped! .env file already exists.');
        }
    }

    /**
     * Generate the application key.
     */
    protected function generateAppKey()
    {
        $this->executeCommand('key:generate', [], 'Generating app key...', 'App key generated.');
    }

    /**
     * Configure the environment settings.
     */
    protected function configureEnv()
    {
        try {
            $this->info('Configuring environment...');

            $envConfig = [
                'APP_NAME' => config('app.name', 'Internara'),
                'APP_TIMEZONE' => config('app.timezone', 'Asia/Jakarta'),
                'APP_LOCALE' => config('app.locale', 'id'),
                'APP_FALLBACK_LOCALE' => config('app.fallback_locale', 'en'),
                'APP_FAKER_LOCALE' => config('app.faker_locale', 'id_ID')
            ];

            foreach ($envConfig as $key => $value) {
                [$value, $rewrite] = is_array($value) ? $value : [$value, true];
                $this->updateEnv($key, $value, $rewrite);
            }

            $this->info('Environment configuration completed.');
        } catch (\Throwable $th) {
            $this->abort('Failed to configure environment.', $th);
        }
    }

    /**
     * Configure the database connection.
     */
    protected function configureDatabase()
    {
        $this->info('Configuring database...');

        if (!confirm('Do you want to configure the database connection?')) {
            $this->info('Skipping database configuration.');
            return;
        }

        $dbTypes = ['sqlite', 'mysql', 'pgsql', 'sqlsrv'];
        $dbType = select('Select the database connection type:', $dbTypes, 0);

        if ($dbType === 'sqlite') {
            $dbConfig = [
                'DB_CONNECTION' => 'sqlite',
            ];
            $this->info("SQLite database will be stored at: " . database_path('database.sqlite'));
        } else {
            $dbConfig = [
                'DB_CONNECTION' => $dbType,
                'DB_HOST' => text('Database host', '127.0.0.1'),
                'DB_PORT' => text('Database port', $dbType === 'pgsql' ? '5432' : '3306'),
                'DB_DATABASE' => text('Database name', 'laravel'),
                'DB_USERNAME' => text('Database username', 'root'),
                'DB_PASSWORD' => password('Database password')
            ];
        }

        foreach ($dbConfig as $key => $value) {
            $this->updateEnv($key, $value);
        }

        $this->info('Database configuration completed.');
    }

    /**
     * Run the database migrations.
     */
    protected function runMigrations()
    {
        $this->executeCommand('migrate', ['--force' => true], 'Running migrations...', 'Migrations completed.', 'Failed to run migrations.');
    }

    /**
     * Run fresh database migrations.
     */
    protected function runFreshMigrations()
    {
        $this->executeCommand('migrate:fresh', ['--force' => 'true']);
    }

    /**
     * Seed the database.
     */
    protected function seedDatabase()
    {
        $this->executeCommand('db:seed', [], 'Seeding database...', 'Seeding completed.', 'Failed to seed database.');
    }

    /**
     * Create a symbolic link to the storage folder.
     */
    protected function createStorageLink()
    {
        $this->info('Creating storage link...');

        if (File::exists(public_path('storage'))) {
            $this->info('Skipped! Storage link already exists.');
            return;
        }

        $this->executeCommand('storage:link', [], 'Creating storage link...', 'Storage linked.', 'Failed to link storage.');
    }

    /**
     * Clean the storage directories.
     */
    protected function cleanStorage()
    {
        $this->info('Cleaning storage...');

        try {
            File::cleanDirectory(storage_path('framework/views'));
            File::cleanDirectory(storage_path('framework/cache/data'));
            File::cleanDirectory(storage_path('framework/livewire-temp'));
            File::cleanDirectory(storage_path('logs'));
            File::deleteDirectory(public_path('uploads'));

            $this->info('Storage cleaned successfully.');
        } catch (\Throwable $th) {
            $this->abort('Failed to clean storage.', $th);
        }
    }

    /**
     * Build the application assets.
     */
    protected function buildAssets()
    {
        $this->info('Building assets...');

        try {
            $this->runShellCommand('npm install');
            $this->runShellCommand('npm run build');

            $this->info('Assets built successfully.');
        } catch (\Throwable $th) {
            $this->abort('Failed to build assets.', $th);
        }
    }

    /**
     * Optimize the application.
     */
    protected function optimize()
    {
        $this->executeCommand('optimize', [], 'Optimizing application...', 'Optimization completed.', 'Unable to optimize the application.', false);
    }

    /**
     * Abort the installation process with an error message.
     *
     * @param string $message
     * @param \Throwable|null $exception
     */
    private function abort(string $message, ?\Throwable $exception = null)
    {
        $this->debug('error', $message, $exception);
        $this->error($message);
        exit(1);
    }

    /**
     * Run an Artisan command.
     *
     * @param string $command
     * @param array $arguments
     * @param string $startMessage
     * @param string $successMessage
     * @param string $errorMessage
     */
    private function executeCommand(string $command, array $arguments = [], string $startMessage = '', string $successMessage = '', string $errorMessage = '', bool $abort = true)
    {
        if ($startMessage) $this->info($startMessage);

        try {
            $this->call($command, $arguments);
            if ($successMessage) $this->info($successMessage);
        } catch (\Throwable $th) {
            if ($abort) {
                $this->abort($errorMessage ?: "Error executing command: $command", $th);
            } else {
                $this->warn($this->debug('warning', $errorMessage ?: "Warning executing command: $command", $th));
            }
        }
    }

    /**
     * Run a shell command.
     *
     * @param string $command
     */
    private function runShellCommand(string $command)
    {
        $process = new Process(explode(' ', $command));
        $process->setTimeout(300);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $this->info($process->getOutput());
    }

    /**
     * Update the .env file with a new value.
     *
     * @param string $key
     * @param string|int|bool $value
     * @param bool $rewrite
     */
    private function updateEnv(string $key, string|int|bool $value, bool $rewrite = true)
    {
        $key = Str::upper(Str::slug($key, '_'));
        $envPath = base_path('.env');

        if (!File::exists($envPath)) $this->checkEnvFile();
        if (!$rewrite && !empty(env($key))) return;

        $envContent = File::get($envPath);
        $envPattern = "/^{$key}=.*/m";

        if (preg_match($envPattern, $envContent)) {
            $envContent = preg_replace($envPattern, "{$key}={$value}", $envContent);
        } else {
            $envContent .= "\n{$key}={$value}";
        }

        File::put($envPath, $envContent);
    }
}
