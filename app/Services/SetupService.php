<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class SetupService extends BaseService
{
    /**
     * The list of all setup steps.
     *
     * @var array<string, string>
     */
    private static array $steps = [
        'setup:welcome' => 'Pengenalan',
        'setup:account' => 'Konfigurasi Administrator',
        'setup:school' => 'Konfigurasi Sekolah',
        'setup:department' => 'Konfigurasi Jurusan',
        'setup:program' => 'Konfigurasi Program',
        'setup:complete' => 'Finalisasi',
    ];

    /**
     * Initiates the installation process for a given step.
     *
     * @param string $step
     * @return LogicResponse
     */
    public function perform(string $step = ''): LogicResponse
    {
        return $this->respond(true)
            ->failWhen($this->isStepInvalid($step))
            ->failWhen($this->ensureNotRateLimited($step))
            ->then(fn () => match ($step) {
                'setup:welcome' => $this->setupWelcome(),
                'setup:account' => $this->setupAccount(),
                'setup:school' => $this->setupSchool(),
                'setup:department' => $this->setupDepartment(),
                'setup:program' => $this->setupProgram(),
                'setup:complete' => $this->setupComplete()
            });
    }

    /**
     * Ensures previous steps have been completed.
     *
     * @param string|string[] $steps
     * @return LogicResponse
     */
    public function ensureStepsCompleted(string|array $steps): LogicResponse
    {
        $steps = (array) $steps;

        foreach ($steps as $step) {
            if (!Session::has($step)) {
                $label = self::$steps[$step] ?? 'langkah sebelumnya';
                return $this->respond(false, "Mohon selesaikan '{$label}' untuk melanjutkan.");
            }
        }

        return $this->respond(true);
    }

    /**
     * Sets up the welcome step.
     *
     * @return LogicResponse
     */
    private function setupWelcome(): LogicResponse
    {
        return $this->processStep('setup:welcome');
    }

    /**
     * Sets up the account configuration step.
     *
     * @return LogicResponse
     */
    private function setupAccount(): LogicResponse
    {
        return $this->checkAndProcess('setup:welcome', 'setup:account', fn () => $this->respond(true)
            ->failWhen(!User::role('owner')->exists(), "Buat akun Administrator terlebih dahulu."));
    }

    /**
     * Sets up the school configuration step.
     *
     * @return LogicResponse
     */
    private function setupSchool(): LogicResponse
    {
        return $this->checkAndProcess('setup:account', 'setup:school', fn () => $this->respond(true)
            ->failWhen(!School::exists(), 'Konfigurasi data sekolah terlebih dahulu.'));
    }

    /**
     * Sets up the department configuration step.
     *
     * @return LogicResponse
     */
    private function setupDepartment(): LogicResponse
    {
        return $this->checkAndProcess('setup:school', 'setup:department');
    }

    /**
     * Sets up the program configuration step.
     *
     * @return LogicResponse
     */
    private function setupProgram(): LogicResponse
    {
        return $this->checkAndProcess('setup:department', 'setup:program');
    }

    /**
     * Finalizes the entire installation process.
     *
     * @return LogicResponse
     */
    private function setupComplete(): LogicResponse
    {
        return $this->respond(true)
            ->failWhen($this->ensureStepsCompleted([
                'setup:welcome',
                'setup:account',
                'setup:school',
                'setup:department',
                'setup:program'
            ]))
            ->then(function ($res) {
                setting('is_installed', true);
                Session::flush();
                return $res->decide(
                    (bool) setting('is_installed'),
                    'Instalasi selesai. Aplikasi siap digunakan!',
                    'Instalasi gagal. Mohon periksa kembali konfigurasi Anda.'
                );
            });
    }

    /**
     * Checks a prerequisite step and then processes the current step.
     *
     * @param string $prerequisiteStep
     * @param string $currentStep
     * @param callable|null $callback
     * @return LogicResponse
     */
    private function checkAndProcess(string $prerequisiteStep, string $currentStep, callable $callback = null): LogicResponse
    {
        $response = $this->ensureStepsCompleted($prerequisiteStep);
        if ($response->fails()) {
            return $response;
        }

        return $this->processStep($currentStep, $callback);
    }

    /**
     * Checks if the installation step is invalid.
     *
     * @param string $step
     * @return LogicResponse
     */
    private function isStepInvalid(string $step): LogicResponse
    {
        return $this->respond(true)
            ->failWhen(!isset(self::$steps[$step]), "Langkah tidak valid. Mohon pastikan URL benar.");
    }

    /**
     * Processes and marks an installation step as completed.
     *
     * @param string $step
     * @param callable|null $callback
     * @return LogicResponse
     */
    private function processStep(string $step, callable $callback = null): LogicResponse
    {
        $response = $this->respond(true);

        if ($callback) {
            $response = $response->then($callback);
        }

        return $response->then(fn ($res) => $this->markAsCompleted($step));
    }

    /**
     * Marks a step as completed in the session.
     *
     * @param string $step
     * @return LogicResponse
     */
    private function markAsCompleted(string $step): LogicResponse
    {
        $label = self::$steps[$step] ?? 'Instalasi';

        try {
            Session::put($step, true);
            return $this->respond(true, "Langkah '{$label}' berhasil diselesaikan.");
        } catch (\Throwable $th) {
            return $this->respond(false, "Terjadi kesalahan saat menyelesaikan langkah '{$label}'. Mohon coba lagi.")
                ->debug($th);
        }
    }

    /**
     * Ensures a step is not rate-limited.
     *
     * @param string $step
     * @param int $maxAttempts
     * @return LogicResponse
     */
    protected function ensureNotRateLimited(string $step, int $maxAttempts = 20): LogicResponse
    {
        return parent::ensureNotRateLimited("setup:{$step}", $maxAttempts);
    }
}
