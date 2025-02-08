<?php

namespace App\Console\Commands;

use App\Debugger;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function Laravel\Prompts\{text, confirm, password, select};

class AppInstaller extends Command
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

    private function handleError(string $message, ?\Throwable $exception = null)
    {
        $this->debug('error', $message, $exception);
        $this->error($message);
        exit(1);
    }

    private function executeCommand(string $command, array $arguments = [], string $startMessage = '', string $successMessage = '', string $errorMessage = '')
    {
        if ($startMessage) $this->info($startMessage);

        try {
            $this->call($command, $arguments);
            if ($successMessage) $this->info($successMessage);
        } catch (\Throwable $th) {
            $this->handleError($errorMessage ?: "Error executing command: $command", $th);
        }
    }

    private function executeShellCommand(string $command)
    {
        $process = new \Symfony\Component\Process\Process(explode(' ', $command));
        $process->setTimeout(300);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $this->info($process->getOutput());
    }

    private function setEnv(string $key, string|int|bool $value, bool $rewrite = true)
    {
        $key = Str::upper(Str::slug($key, '_'));
        $envPath = base_path('.env');

        if (!File::exists($envPath)) $this->checkAndCreateEnv();
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

    private function clearCache()
    {
        $this->executeCommand('optimize:clear', [], 'Clearing cache...', 'Cache cleared.', 'Failed to clear cache.');
    }

    private function checkAndCreateEnv()
    {
        $this->info('Checking application environment...');

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

    private function generateKey()
    {
        $this->executeCommand('key:generate', [], 'Generating application key...', 'Application key generated.');
    }

    private function setupEnvConfig()
    {
        try {
            $this->info('Setting up application environment configuration...');

            $envConfig = [
                'APP_NAME' => config('app.name', 'Internara'),
                'APP_TIMEZONE' => config('app.timezone', 'Asia/Jakarta'),
                'APP_LOCALE' => config('app.locale', 'id'),
                'APP_FALLBACK_LOCALE' => config('app.fallback_locale', 'en'),
                'APP_FAKER_LOCALE' => config('app.faker_locale', 'id_ID')
            ];

            foreach ($envConfig as $key => $value) {
                [$value, $rewrite] = is_array($value) ? $value : [$value, true];
                $this->setEnv($key, $value, $rewrite);
            }

            $this->info('Application environment configurations successfully completed.');
        } catch (\Throwable $th) {
            $this->handleError('Failed to setup application environment configuration.', $th);
            throw $th;
        }
    }

    private function setupDBConnection()
    {
        $this->info('Starting database connection setup...');

        if (!confirm('Do you want to configure the database connection?')) {
            $this->info('Skipping database configuration.');
            return;
        }

        $dbConnectionTypes = ['sqlite', 'mysql', 'pgsql', 'sqlsrv'];
        $selectedDbType = select('Select the database connection type:', $dbConnectionTypes, 0);

        if ($selectedDbType === 'sqlite') {
            $dbConfig = [
                'DB_CONNECTION' => 'sqlite',
            ];
            $this->info("SQLite database will be stored at: " . database_path('database.sqlite'));
        } else {
            $dbConfig = [
                'DB_CONNECTION' => $selectedDbType,
                'DB_HOST' => text('Database host', '127.0.0.1'),
                'DB_PORT' => text('Database port', $selectedDbType === 'pgsql' ? '5432' : '3306'),
                'DB_DATABASE' => text('Database name', 'laravel'),
                'DB_USERNAME' => text('Database username', 'root'),
                'DB_PASSWORD' => password('Database password')
            ];
        }

        foreach ($dbConfig as $key => $value) {
            $this->setEnv($key, $value);
        }

        $this->info('Database connection successfully configured.');
    }

    private function runMigration()
    {
        $this->executeCommand('migrate', ['--force' => true], 'Running migrations...', 'Migrations completed.', 'Failed to run migrations.');
    }

    private function freshMigration()
    {
        $this->executeCommand('migrate:fresh', ['--force' => 'true']);
    }

    private function runSeeder()
    {
        $this->executeCommand('db:seed', [], 'Seeding database...', 'Seeding completed.', 'Failed to seed database.');
    }

    private function linkStorage()
    {
        $this->info('Linking storage folder...');

        if (File::exists(public_path('storage'))) {
            $this->info('Skipped! Storage link already exists.');
            return;
        }

        $this->executeCommand('storage:link', [], 'Creating storage link...', 'Storage linked.', 'Failed to link storage.');
    }

    private function cleanStorage()
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
            $this->handleError('Failed to clean storage.', $th);
        }
    }

    private function buildApp()
    {
        $this->info('Building application assets...');

        try {
            $this->executeShellCommand('npm install');
            $this->executeShellCommand('npm run build');

            $this->info('Application assets built successfully.');
        } catch (\Throwable $th) {
            $this->handleError('Failed to build application assets.', $th);
        }
    }

    private function optimizeApp()
    {
        $this->executeCommand('optimize', [], 'Optimizing application...', 'Optimization completed.', 'Failed to optimize.');
    }

    private function performInstall()
    {
        $this->clearCache();
        $this->checkAndCreateEnv();
        $this->generateKey();
        $this->setupEnvConfig();
        $this->setupDBConnection();
        $this->runMigration();
        $this->freshMigration();
        $this->runSeeder();
        $this->linkStorage();
        $this->cleanStorage();
        $this->buildApp();
        $this->optimizeApp();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $APP_URL = config('app.url', 'localhost:8000');

        $this->info('Starting to install application...');

        $this->performInstall();

        $this->info('Application successfully installed.');
        $this->info("\nRun 'php artisan serve' to start server.");
        $this->info("Open $APP_URL in your browser.");
    }
}
