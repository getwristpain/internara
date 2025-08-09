<?php

namespace App\Services;

use RateLimiter;
use App\Services\Service;
use App\Helpers\Transform;
use App\Helpers\LogicResponse;
use Illuminate\Support\Facades\Session;

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

    protected function setupStart(): LogicResponse
    {
        return $this->markAsCompleted('setup:welcome');
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

    protected function markAsCompleted(string $step): LogicResponse
    {
        $label = $this->steps[$step] ?? 'Instalasi';

        try {
            Session::put($step, true);
            return $this->response()->success("Berhasil menyelesaikan langkah {$label}.");
        } catch (\Throwable $th) {
            return $this->response()->error("Gagal menyelesaikan langkah {$label}.")
                ->debug($th);
        }
    }

    protected function ensureNotRateLimited(string $step): LogicResponse
    {
        if (!RateLimiter::tooManyAttempts($step, 5)) {
            $seconds = RateLimiter::availableIn($step);
            $message = Transform::from('Gagal melanjutkan instalasi. Tunggu hingga :seconds detik.')
                ->replace(':seconds', $seconds)
                ->toString();

            return $this->response()->error($message);
        }

        RateLimiter::increment($step);
        return $this->response();
    }

    protected function ensureNotInstalled(): LogicResponse
    {
        $isInstalled = setting()->isInstalled();
        return $this->response()->make(!$isInstalled, $isInstalled ? 'Gagal melanjutkan instalasi: Aplikasi telah terinstal.' : 'Selesaikan proses instalasi.');
    }
}
