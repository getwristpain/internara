<?php

namespace App\Console\Commands;

use App\Helpers\Debugger;
use Illuminate\Console\Command;
use App\Services\Console\AppInstallService;

/**
 * ------------------------------------------------------------------------
 * Application Installation Command
 * ------------------------------------------------------------------------
 * Automates the installation and setup process, including environment
 * configuration, database migration, and application optimization.
 */
class AppInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Automates the installation and setup process for the application.';

    /**
     * ------------------------------------------------------------------------
     * Handle Command Execution
     * ------------------------------------------------------------------------
     * Executes the installation service and handles error reporting.
     *
     * @return int Status code representing success or failure.
     */
    public function handle(): int
    {
        $appUrl = config('app.url', 'http://localhost:8000');
        $startTime = microtime(true);

        $this->info('Application installation process has started.');
        $this->newLine();

        try {
            app(AppInstallService::class, ['command' => $this])->run();
        } catch (\Throwable $th) {
            $message = 'A critical error occurred during installation. Please check the logs for more details.';

            $this->newLine();
            $this->error($message);
            Debugger::handle($th);

            return self::FAILURE;
        }

        $duration = round(microtime(true) - $startTime, 2);

        $this->newLine();
        $this->info("[Duration: {$duration}s] Installation completed successfully.");

        $this->newLine();
        $this->info('To start the server, run: php artisan serve');
        $this->info("You can now access the application at: {$appUrl}");

        return self::SUCCESS;
    }
}
