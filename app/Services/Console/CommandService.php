<?php

namespace App\Services\Console;

use App\Services\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use App\Helpers\Debugger;

abstract class CommandService extends Service
{
    /**
     * The console command instance.
     */
    protected Command $command;

    /**
     * Constructor.
     *
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
        parent::__construct();
    }

    /**
     * Run an Artisan command with optional feedback.
     */
    protected function runArtisan(
        string $command,
        array $arguments = [],
        string $startMessage = '',
        string $successMessage = '',
        string $errorMessage = '',
        bool $abort = true
    ): void {
        $command = trim($command);

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
                $this->skipWithWarn($errorMessage ?: "Warning during $command", $th);
                return;
            }

            $this->fail($errorMessage ?: "Error during $command", $th);
        }
    }

    /**
     * Run shell command with output capture.
     */
    protected function runShellCommand(string $command): void
    {
        $command = trim($command);

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
     * Update or append value in .env file.
     */
    protected function updateEnv(string $key, string|int|bool $value, bool $rewrite = true): void
    {
        $key = Str::upper(Str::slug($key, '_'));
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            $this->command->error('.env file is missing.');
            return;
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
     * Handle fatal error and terminate execution.
     */
    protected function fail(string $message, ?\Throwable $exception = null): void
    {
        $this->command->error($message);
        Debugger::handle($exception ?? $message);
        exit(1);
    }

    /**
     * Handle non-fatal warning and continue.
     */
    protected function skipWithWarn(string $message, ?\Throwable $exception = null): void
    {
        $this->command->warn($message);
        Debugger::handle($exception ?? $message);
    }
}
