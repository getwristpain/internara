<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Helpers\Transform;
use App\Models\School;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Session;

class SetupService extends BaseService
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
            ->failWhen(!isset($this->steps[$step]), "Gagal melanjutkan instalasi: '{$step}' tidak diizinkan.")
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
            ->failWhen(!isset($this->steps[$steps]), "Gagal melanjutkan instalasi: '{$steps}' tidak diizinkan.")
            ->failWhen(!Session::has($steps), "Pastikan untuk menyelesaikan langkah {$label} sebelum melanjutkan.")
            ->then(fn ($res) => $res->success());
    }

    protected function setupWelcome(): LogicResponse
    {
        return $this->response()
            ->then($this->markAsCompleted('setup:welcome'));
    }

    protected function setupAccount(): LogicResponse
    {
        return $this->response()
            ->failWhen($this->ensureStepsCompleted('setup:welcome'))
            ->failWhen(!(User::role('owner')->exists()), "Buat akun Administrator terlebih dahulu sebelum melanjutkan.")
            ->then($this->markAsCompleted('setup:account'));
    }

    protected function setupSchool(): LogicResponse
    {
        $school = School::first();

        return $this->response()
            ->failWhen($this->ensureStepsCompleted('setup:account'))
            ->failWhen(empty($school), 'Konfigurasi data sekolah terlebih dahulu sebelum melanjutkan.')
            ->then($this->markAsCompleted('setup:school'));
    }

    protected function setupDepartment(): LogicResponse
    {
        return $this->response()
            ->failWhen($this->ensureStepsCompleted('setup:school'))
            ->then($this->markAsCompleted('setup:department'));
    }

    protected function setupProgram()
    {
        return $this->response()
            ->failWhen($this->ensureStepsCompleted('setup:department'))
            ->then($this->markAsCompleted('setup:program'));
    }

    protected function setupComplete(): LogicResponse
    {
        return $this->response()
            ->failWhen($this->ensureStepsCompleted([
                'setup:welcome',
                'setup:account',
                'setup:school',
                'setup:department',
                'setup:program'
            ]))->failWhen($this->markAsCompleted('setup:complete'))
            ->then(function ($res) {
                session()->regenerate();
                return $res->decide(
                    (bool) setting('is_installed', true) ?? false,
                    'Berhasil menyelesaikan instalasi.',
                    'Gagal menyelesaikan instalasi.'
                );
            });
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

    public function ensureNotRateLimited(string $step, int $maxAttempts = 20): LogicResponse
    {
        $key = "setup:{$step}";
        return parent::ensureNotRateLimited($key, $maxAttempts);
    }
}
