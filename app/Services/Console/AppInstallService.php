<?php

namespace App\Services\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

/**
 * ------------------------------------------------------------------------
 * AppInstallService
 * ------------------------------------------------------------------------
 * Service to handle automated application installation and setup.
 */
class AppInstallService extends CommandService
{
    public function __construct(Command $command)
    {
        parent::__construct($command);
    }

    /**
     * Run the full installation process.
     */
    public function run(): void
    {
        $this->command->newLine();
        $this->clearCache();

        $this->command->newLine();
        $this->cleanLog();

        $this->command->newLine();
        $this->ensureEnvFileExists();

        $this->command->newLine();
        $this->generateAppKey();

        $this->command->newLine();
        $this->configureBasicEnvironment();

        $this->command->newLine();
        $this->configureDatabase();

        $this->command->newLine();
        $this->runMigration();

        $this->command->newLine();
        $this->runFreshMigration();

        $this->command->newLine();
        $this->seedDatabase();

        $this->command->newLine();
        $this->createStorageSymlink();

        $this->command->newLine();
        $this->cleanStorage();

        $this->command->newLine();
        $this->syncLocationDataset();

        $this->command->newLine();
        $this->buildFrontendAssets();

        $this->command->newLine();
        $this->optimizeApplication();
    }

    /**
     * Clear application cache.
     */
    protected function clearCache(): void
    {
        $this->runArtisan('optimize:clear', [], 'Clearing application cache...');
    }

    /**
     * Clear activity logs.
     */
    protected function cleanLog(): void
    {
        $this->runArtisan('activitylog:clean', [], 'Cleaning activity logs...');
    }

    /**
     * Ensure that the .env file exists.
     */
    protected function ensureEnvFileExists(): void
    {
        $this->command->info('Validating environment file...');
        $envPath = base_path('.env');
        $envExamplePath = base_path('.env.example');

        if (!File::exists($envPath)) {
            $this->command->info('.env file not found. Attempting to copy from example...');
            if (File::exists($envExamplePath)) {
                File::copy($envExamplePath, $envPath);
                $this->command->info('.env file successfully created from .env.example.');
            } else {
                $this->fail('.env.example file is missing. Please provide it.');
            }
        } else {
            $this->command->info('.env file already exists. Skipped.');
        }
    }

    /**
     * Generate application key.
     */
    protected function generateAppKey(): void
    {
        $this->runArtisan('key:generate', [], 'Generating application key...', 'Application key generated.');
    }

    /**
     * Configure basic environment variables.
     */
    protected function configureBasicEnvironment(): void
    {
        try {
            $this->command->info('Configuring basic environment variables...');
            $env = [
                'APP_NAME' => config('app.name', 'Internara'),
                'APP_TIMEZONE' => config('app.timezone', 'Asia/Jakarta'),
                'APP_LOCALE' => config('app.locale', 'id'),
                'APP_FALLBACK_LOCALE' => config('app.fallback_locale', 'id'),
                'APP_FAKER_LOCALE' => config('app.faker_locale', 'id_ID'),
            ];

            foreach ($env as $key => $value) {
                $this->updateEnv($key, $value);
            }

            $this->command->info('Environment variables configured.');
        } catch (\Throwable $th) {
            $this->fail('Failed to configure environment variables.', $th);
        }
    }

    /**
     * Configure database connection via prompt.
     */
    protected function configureDatabase(): void
    {
        $this->command->info('Configuring database connection...');
        if (!confirm('Configure database connection now?')) {
            $this->command->info('Database configuration skipped.');
            return;
        }

        $dbTypes = ['sqlite', 'mysql', 'pgsql', 'sqlsrv'];
        $dbType = select('Select database connection type:', $dbTypes, 0);
        $db = [];

        if ($dbType === 'sqlite') {
            $db['DB_CONNECTION'] = 'sqlite';
            $this->command->info('SQLite will be used at: ' . database_path('database.sqlite'));
        } else {
            $db = [
                'DB_CONNECTION' => $dbType,
                'DB_HOST' => text('Database host', '127.0.0.1'),
                'DB_PORT' => text('Database port', $dbType === 'pgsql' ? '5432' : '3306'),
                'DB_DATABASE' => text('Database name', 'laravel'),
                'DB_USERNAME' => text('Database username', 'root'),
                'DB_PASSWORD' => password('Database password'),
            ];
        }

        foreach ($db as $key => $value) {
            $this->updateEnv($key, $value);
        }

        $this->command->info('Database connection configured.');
    }

    /**
     * Run Laravel database migrations.
     */
    protected function runMigration(): void
    {
        $this->runArtisan(
            'migrate',
            ['--force' => true],
            'Running database migrations...',
            'Migration completed.',
            'Migration failed.'
        );
    }

    /**
     * Run a fresh Laravel migration.
     */
    protected function runFreshMigration(): void
    {
        $this->runArtisan('migrate:fresh', ['--force' => true]);
    }

    /**
     * Seed initial database data.
     */
    protected function seedDatabase(): void
    {
        $this->runArtisan(
            'db:seed',
            [],
            'Seeding initial data...',
            'Database seeding completed.',
            'Database seeding failed.'
        );
    }

    /**
     * Create storage symbolic link.
     */
    protected function createStorageSymlink(): void
    {
        $this->command->info('Creating storage symlink...');

        if (File::exists(public_path('storage'))) {
            $this->command->info('Symlink already exists. Skipped.');
            return;
        }

        $this->runArtisan(
            'storage:link',
            [],
            'Creating symbolic link...',
            'Storage link created.',
            'Storage link creation failed.'
        );
    }

    /**
     * Clean storage directory.
     */
    protected function cleanStorage(): void
    {
        $this->runArtisan('storage:clean', [], abort: false);
    }

    /**
     * Synchronize location dataset.
     */
    protected function syncLocationDataset(): void
    {
        $this->runArtisan('location:sync', ['--restore' => true]);
    }

    /**
     * Build frontend assets using npm.
     */
    protected function buildFrontendAssets(): void
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
     * Optimize Laravel application.
     */
    protected function optimizeApplication(): void
    {
        $this->runArtisan(
            'optimize',
            [],
            'Optimizing application...',
            'Optimization complete.',
            'Optimization failed.',
            false
        );
    }
}
