<?php

namespace App\Console\Commands;

use App\Helpers\Debugger;
use Illuminate\Console\Command;
use App\Services\Console\AppInstallService;

/**
 * Command to automate the installation and setup of the application.
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
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automates the installation and setup process, including environment configuration, database migrations, and optimizations.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $appUrl = config('app.url', 'http://localhost:8000');
        $startTime = microtime(true);

        $this->info('Application installation has started.');
        $this->newLine();

        try {
            app(AppInstallService::class, ['command' => $this])->install();
        } catch (\Throwable $th) {
            $message = 'A critical error occurred during the installation process. Please check the logs for more details.';

            $this->newLine();
            $this->error($message);
            Debugger::debug($th, $message);

            return self::FAILURE;
        }

        $endTime = microtime(true);
        $duration = round($endTime - $startTime, 2);

        $this->newLine();
        $this->info("[Duration: {$duration}s] Installation completed successfully.");

        $this->newLine();
        $this->info('To start the server, run: php artisan serve');
        $this->info("You can now access the application at: {$appUrl}");

        return self::SUCCESS;
    }
}
