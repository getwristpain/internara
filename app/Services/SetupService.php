<?php

namespace App\Services;

use App\Models\School;
use App\Models\User;
use RateLimiter;
use App\Services\Service;
use App\Helpers\Transform;
use App\Helpers\LogicResponse;
use Illuminate\Support\Facades\Session;

class SetupService extends Service
{
    protected array $steps = [
        'setup:welcome' => 'Introduksi',
        'setup:account' => 'Konfigurasi Administrator',
        'setup:school' => 'Konfigurasi Sekolah',
        'setup:department' => 'Konfigurasi Jurusan',
        'setup:program' => 'Konfigurasi Program',
        'setup:complete' => 'Finalisasi',
    ];

    public function perform(string $step = ''): LogicResponse
    {
        return $this->response()
            ->failWhen(!isset($this->steps[$step]), "Gagal melanjutkan instalasi: '{$step}' tidak diizinkan")
            ->failWhen($this->ensureNotInstalled())
            ->failWhen($this->ensureNotRateLimited($step))
            ->then(match ($step) {
                'setup:welcome' => $this->setupWelcome(),
                'setup:account' => $this->setupAccount(),
                'setup:school' => $this->setupSchool(),
                'setup:department' => $this->setupDepartment(),
                'setup:program' => $this->setupProgram(),
                'setup:complete' => $this->setupComplete()
            });
    }

    public function ensureStepsCompleted(string|array $steps): LogicResponse
    {
        if (is_array($steps)) {
            foreach ($steps as $step) {
                $res = $this->ensureStepsCompleted($step);

                if ($res->fails()) {
                    return $res;
                }
            }

            return $res;
        }

        $label = $this->steps[$steps] ?? 'sebelumnya';

        return $this->response()
            ->failWhen(!isset($this->steps[$steps]), "Gagal melanjutkan instalasi: '{$steps}' tidak diizinkan")
            ->failWhen(!Session::has($steps), "Pastikan untuk menyelesaikan langkah {$label} sebelum melanjutkan")
            ->then(fn ($res) => $res->success());
    }

    protected function setupWelcome(): LogicResponse
    {
        return $this->markAsCompleted('setup:welcome');
    }

    protected function setupAccount()
    {
        return $this->response()
            ->failWhen($this->ensureStepsCompleted('setup:welcome'))
            ->failWhen(!(User::where(['type' => 'owner'])->exists()), "Buat akun Administrator terlebih dahulu sebelum melanjutkan")
            ->then($this->markAsCompleted('setup:account'));
    }

    protected function setupSchool()
    {
        $school = School::first();

        return $this->response()
            ->failWhen($this->ensureStepsCompleted('setup:account'))
            ->failWhen(empty($school), 'Konfigurasi data sekolah terlebih dahulu sebelum melanjutkan')
            ->then($this->markAsCompleted('setup:school'));
    }

    protected function setupDepartment()
    {
        return $this->response()
            ->failWhen($this->ensureStepsCompleted('setup:school'))
            ->then($this->markAsCompleted('setup:department'));
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
            return $this->response()->success("Berhasil menyelesaikan langkah {$label}");
        } catch (\Throwable $th) {
            return $this->response()->error("Gagal menyelesaikan langkah {$label}")
                ->debug($th);
        }
    }

    protected function ensureNotRateLimited(string $step, int $maxAttempts = 20): LogicResponse
    {
        if (RateLimiter::tooManyAttempts($step, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($step);
            $message = Transform::from('Terlalu banyak melakukan aksi. Tunggu hingga :seconds detik.')
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
        return $this->response()
        ->decide(!$isInstalled, 'Selesaikan proses instalasi.', 'Gagal memulai instalasi: Aplikasi telah terinstal.');
    }
}
