<?php

namespace App\Services\Console;

use App\Services\Service;
use App\Helpers\Debugger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

/**
 * Handles the automated installation and setup process for the application.
 */
class AppInstallService extends Service
{
    /**
     * The console command instance.
     *
     * @var Command
     */
    protected Command $command;

    /**
     * AppInstallService constructor.
     *
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        parent::__construct();
        $this->command = $command;
    }

    /**
     * Run the full installation process.
     *
     * @return void
     */
    public function install(): void
    {
        $this->clearCache();
        $this->command->newLine();

        $this->clearLogs();
        $this->command->newLine();

        $this->checkEnvFile();
        $this->command->newLine();

        $this->generateAppKey();
        $this->command->newLine();

        $this->configureEnv();
        $this->command->newLine();

        $this->configureDatabase();
        $this->command->newLine();

        $this->runMigrations();
        $this->command->newLine();

        $this->runFreshMigrations();
        $this->command->newLine();

        $this->seedDatabase();
        $this->command->newLine();

        $this->createStorageLink();
        $this->command->newLine();

        $this->cleanStorage();
        $this->command->newLine();

        $this->syncDataset();
        $this->command->newLine();

        $this->buildAssets();
        $this->command->newLine();

        $this->optimize();
        $this->command->newLine();
    }

    /**
     * Clear application cache.
     *
     * @return void
     */
    protected function clearCache(): void
    {
        $this->runArtisan('optimize:clear', [], 'Clearing application cache...');
    }

    /**
     * Remove application logs.
     *
     * @return void
     */
    protected function clearLogs(): void
    {
        $this->runArtisan('activitylog:clean', [], 'Removing application logs...');
    }

    /**
     * Ensure the .env file exists.
     *
     * @return void
     */
    protected function checkEnvFile(): void
    {
        $this->command->info('Validating environment file...');
        $envPath = base_path('.env');
        $envExamplePath = base_path('.env.example');
        if (!File::exists($envPath)) {
            $this->command->info('Environment file not found. Creating from example...');
            if (File::exists($envExamplePath)) {
                File::copy($envExamplePath, $envPath);
                $this->command->info('Environment file created from .env.example.');
            } else {
                $this->abort('The .env.example file is missing. Please provide the example file.');
            }
        } else {
            $this->command->info('Environment file already exists. Skipping creation.');
        }
    }

    /**
     * Generate the application key.
     *
     * @return void
     */
    protected function generateAppKey(): void
    {
        $this->runArtisan('key:generate', [], 'Generating application key...', 'Application key generated.');
    }

    /**
     * Configure environment variables.
     *
     * @return void
     */
    protected function configureEnv(): void
    {
        try {
            $this->command->info('Configuring environment variables...');
            $envConfig = [
                'APP_NAME' => config('app.name', 'Internara'),
                'APP_TIMEZONE' => config('app.timezone', 'Asia/Jakarta'),
                'APP_LOCALE' => config('app.locale', 'id'),
                'APP_FALLBACK_LOCALE' => config('app.fallback_locale', 'en'),
                'APP_FAKER_LOCALE' => config('app.faker_locale', 'id_ID'),
            ];
            foreach ($envConfig as $key => $value) {
                $this->updateEnv($key, $value);
            }
            $this->command->info('Environment variables configured successfully.');
        } catch (\Throwable $th) {
            $this->abort('Failed to configure environment variables.', $th);
        }
    }

    /**
     * Configure the database connection.
     *
     * @return void
     */
    protected function configureDatabase(): void
    {
        $this->command->info('Configuring database connection...');
        if (!confirm('Would you like to configure the database connection now?')) {
            $this->command->info('Database configuration skipped.');
            return;
        }
        $dbTypes = ['sqlite', 'mysql', 'pgsql', 'sqlsrv'];
        $dbType = select('Select the database connection type:', $dbTypes, 0);
        $dbConfig = [];
        if ($dbType === 'sqlite') {
            $dbConfig['DB_CONNECTION'] = 'sqlite';
            $this->command->info('SQLite database will be used at: ' . database_path('database.sqlite'));
        } else {
            $dbConfig = [
                'DB_CONNECTION' => $dbType,
                'DB_HOST' => text('Database host', '127.0.0.1'),
                'DB_PORT' => text('Database port', $dbType === 'pgsql' ? '5432' : '3306'),
                'DB_DATABASE' => text('Database name', 'laravel'),
                'DB_USERNAME' => text('Database username', 'root'),
                'DB_PASSWORD' => password('Database password'),
            ];
        }
        foreach ($dbConfig as $key => $value) {
            $this->updateEnv($key, $value);
        }
        $this->command->info('Database connection configured successfully.');
    }

    /**
     * Run database migrations.
     *
     * @return void
     */
    protected function runMigrations(): void
    {
        $this->runArtisan('migrate', ['--force' => true], 'Running database migrations...', 'Database migrations completed.', 'Database migration failed.');
    }

    /**
     * Run fresh database migrations.
     *
     * @return void
     */
    protected function runFreshMigrations(): void
    {
        $this->runArtisan('migrate:fresh', ['--force' => true]);
    }

    /**
     * Seed the database.
     *
     * @return void
     */
    protected function seedDatabase(): void
    {
        $this->runArtisan('db:seed', [], 'Seeding database...', 'Database seeding completed.', 'Database seeding failed.');
    }

    /**
     * Create the storage symbolic link.
     *
     * @return void
     */
    protected function createStorageLink(): void
    {
        $this->command->info('Creating storage symbolic link...');
        if (File::exists(public_path('storage'))) {
            $this->command->info('Storage symbolic link already exists. Skipping.');
            return;
        }
        $this->runArtisan('storage:link', [], 'Creating storage symbolic link...', 'Storage symbolic link created.', 'Failed to create storage symbolic link.');
    }

    /**
     * Clean storage directories.
     *
     * @return void
     */
    protected function cleanStorage(): void
    {
        $this->command->info('Cleaning storage directories...');
        $foldersToClean = [
            'app/private/cache',
            'app/private/livewire-tmp',
            'app/public/uploads',
            'framework/cache/data',
            'framework/livewire-temp',
            'framework/views',
            'logs',
        ];
        try {
            foreach ($foldersToClean as $folder) {
                $directory = storage_path($folder);
                if (File::exists($directory)) {
                    File::cleanDirectory($directory);
                }
            }
            $this->command->info('Storage directories cleaned successfully.');
        } catch (\Throwable $th) {
            $this->abort('Failed to clean storage directories.', $th);
        }
    }

    /**
     * Synchronize the dataset.
     *
     * @return void
     */
    protected function syncDataset(): void
    {
        $this->runArtisan('location:sync', ['--restore' => true]);
    }

    /**
     * Build frontend assets.
     *
     * @return void
     */
    protected function buildAssets(): void
    {
        $this->command->info('Building frontend assets...');
        try {
            $this->runShellCommand('npm install');
            $this->runShellCommand('npm run build');
            $this->command->info('Frontend assets built successfully.');
        } catch (\Throwable $th) {
            $this->skipWithWarn('Failed to build frontend assets.', $th);
        }
    }

    /**
     * Optimize the application.
     *
     * @return void
     */
    protected function optimize(): void
    {
        $this->runArtisan('optimize', [], 'Optimizing application...', 'Application optimized.', 'Application optimization failed.', false);
    }

    /**
     * Run an Artisan command with optional messaging.
     *
     * @param string $command
     * @param array $arguments
     * @param string $startMessage
     * @param string $successMessage
     * @param string $errorMessage
     * @param bool $abort
     * @return void
     */
    protected function runArtisan(
        string $command,
        array $arguments = [],
        string $startMessage = '',
        string $successMessage = '',
        string $errorMessage = '',
        bool $abort = true
    ): void {
        if ($startMessage) {
            $this->command->info($startMessage);
        }
        try {
            $this->command->call($command, $arguments);
            if ($successMessage) {
                $this->command->info($successMessage);
            }
        } catch (\Throwable $th) {
            if (!$abort) {
                $this->skipWithWarn($errorMessage ?: "Warning executing command: $command", $th);
                return;
            }
            $this->abort($errorMessage ?: "Error executing command: $command", $th);
        }
    }

    /**
     * Run a shell command.
     *
     * @param string $command
     * @return void
     */
    protected function runShellCommand(string $command): void
    {
        $this->command->newLine();
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(300);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
        $output = trim($process->getOutput());
        if ($output) {
            $this->command->info($output);
        }
    }

    /**
     * Update or add a value in the .env file.
     *
     * @param string $key
     * @param string|int|bool $value
     * @param bool $rewrite
     * @return void
     */
    protected function updateEnv(string $key, string|int|bool $value, bool $rewrite = true): void
    {
        $key = Str::upper(Str::slug($key, '_'));
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            $this->checkEnvFile();
        }
        if (!$rewrite && !empty(env($key))) {
            return;
        }
        $envContent = File::get($envPath);
        $envPattern = "/^{$key}=.*/m";
        if (preg_match($envPattern, $envContent)) {
            $envContent = preg_replace($envPattern, "{$key}={$value}", $envContent);
        } else {
            $envContent .= "\n{$key}={$value}";
        }
        File::put($envPath, $envContent);
    }

    /**
     * Abort the installation process with an error message.
     *
     * @param string $message
     * @param \Throwable|null $exception
     * @return void
     */
    protected function abort(string $message, ?\Throwable $exception = null): void
    {
        if (!$exception) {
            $exception = new \Exception($message);
        }
        $this->command->error($message);
        Debugger::debug($exception, $message);
        exit(1);
    }

    /**
     * Skip a step with a warning message.
     *
     * @param string $message
     * @param \Throwable|null $exception
     * @return void
     */
    protected function skipWithWarn(string $message, ?\Throwable $exception = null): void
    {
        $this->command->warn($message);
        Debugger::debug($exception, $message);
    }
}
