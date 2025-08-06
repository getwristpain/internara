<?php

namespace App\Services;

use RateLimiter;
use App\Services\Service;
use App\Helpers\Transform;
use App\Helpers\LogicResponse;

class SetupService extends Service
{
    protected array $steps = [
        'setup:start' => 'Introduksi',
        'setup:account' => 'Konfigurasi Administrator',
        'setup:school' => 'Konfigurasi Sekolah',
        'setup:department' => 'Konfigurasi Jurusan',
        'setup:program' => 'Konfigurasi Program',
        'setup:complete' => 'Finalisasi',
    ];

    public function perform(string $step = ''): LogicResponse
    {
        return $this->response()
            ->failWhen(!isset($this->steps[$step]), "Gagal melanjutkan instalasi: '{$step}' tidak diizinkan.")
            ->failWhen($this->ensureNotInstalled())
            ->failWhen($this->ensureNotRateLimited($step))
            ->then(match ($step) {
                'setup:start' => $this->setupStart(),
                'setup:account' => $this->setupAccount(),
                'setup:school' => $this->setupSchool(),
                'setup:department' => $this->setupDepartment(),
                'setup:program' => $this->setupProgram(),
                'setup:complete' => $this->setupComplete()
            });
    }

    protected function setupStart()
    {
        //
    }

    protected function setupAccount()
    {
        //
    }

    protected function setupSchool()
    {
        //
    }

    protected function setupDepartment()
    {
        //
    }

    protected function setupProgram()
    {
        //
    }

    protected function setupComplete()
    {
        //
    }

    protected function ensureNotRateLimited(string $step): LogicResponse
    {
        if (!RateLimiter::tooManyAttempts($step, 5)) {
            $seconds = RateLimiter::availableIn($step);
            $message = Transform::from('Gagal melanjutkan instalasi. Tunggu hingga :seconds detik.')
                ->replace(':seconds', $seconds)
                ->toString();

            return $this->response()->fail($message);
        }

        RateLimiter::increment($step);
        return $this->response()->success();
    }

    protected function ensureNotInstalled(): LogicResponse
    {
        $isInstalled = setting()->isInstalled();
        return $this->response()->make(!$isInstalled, $isInstalled ? 'Gagal melanjutkan instalasi: Aplikasi telah terinstal.' : 'Selesaikan proses instalasi.');
    }
}
