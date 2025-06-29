<?php

namespace App\Services;

use App\Helpers\LogicResponse;

/**
 * Service untuk menangani langkah instalasi aplikasi.
 */
class InstallationService extends Service
{
    /**
     * Konstruktor InstallationService.
     */
    public function __construct()
    {
        parent::__construct();
        $this->useServices([
            OwnerService::class,
            SchoolService::class,
            SettingService::class,
            StatusService::class,
        ]);
    }

    /**
     * Menjalankan langkah instalasi yang dipilih.
     *
     * @param string $step
     * @return LogicResponse
     */
    public function performInstall(string $step): LogicResponse
    {
        return match ($step) {
            'welcome'           => $this->installWelcome(),
            'school_config'     => $this->installSchool(),
            'department_setup'  => $this->installDepartment(),
            'owner_setup'       => $this->installOwner(),
            'complete'          => $this->installComplete(),
            default             => $this->response()
                                        ->failure('Langkah instalasi yang dipilih tidak dikenali.')
                                        ->storeLog(),
        };
    }

    /**
     * Tandai langkah welcome sebagai selesai.
     *
     * @return LogicResponse
     */
    protected function installWelcome(): LogicResponse
    {
        return $this->markAsCompleted('welcome');
    }

    /**
     * Validasi dan tandai langkah konfigurasi sekolah sebagai selesai.
     *
     * @return LogicResponse
     */
    protected function installSchool(): LogicResponse
    {
        $firstSchool = $this->schoolService->model()->first();

        if (!$firstSchool) {
            return $this->response()
                ->failure("Data sekolah belum ditemukan. Silakan pastikan data 'Sekolah' sudah dibuat sebelum melanjutkan.");
        }

        return $this->markAsCompleted('school_config');
    }

    /**
     * Validasi dan tandai langkah setup jurusan sebagai selesai.
     *
     * @return LogicResponse
     */
    protected function installDepartment(): LogicResponse
    {
        $department = $this->schoolService
            ->model()->instance()
            ->departments()
            ->first();

        if (!$department) {
            return $this->response()
                ->failure("Data jurusan belum ditemukan. Silakan pastikan data 'Jurusan' sudah dibuat sebelum melanjutkan.");
        }

        return $this->markAsCompleted('department_setup');
    }

    /**
     * Validasi dan tandai langkah setup pemilik sebagai selesai.
     *
     * @return LogicResponse
     */
    protected function installOwner(): LogicResponse
    {
        $owner = $this->ownerService->model()->instance();

        if (!$owner) {
            return $this->response()
                ->failure("Data pemilik belum ditemukan. Silakan pastikan data 'Pemilik' sudah dibuat sebelum melanjutkan.");
        }

        return $this->markAsCompleted('owner_setup');
    }

    /**
     * Menyelesaikan proses instalasi.
     *
     * @return LogicResponse
     */
    protected function installComplete(): LogicResponse
    {
        $markAsCompleted = $this->markAsCompleted('complete');
        if ($markAsCompleted->fails()) {
            return $markAsCompleted;
        }

        return $this->settingService->set('is_installed', true);
    }

    /**
     * Mengecek apakah langkah instalasi tertentu sudah selesai.
     *
     * @param string $step
     * @return bool
     */
    public function isStepCompleted(string $step): bool
    {
        return $this->statusService->isMarked($step, 'installation');
    }

    /**
     * Tandai langkah instalasi tertentu sebagai selesai.
     *
     * @param string $step
     * @return LogicResponse
     */
    protected function markAsCompleted(string $step): LogicResponse
    {
        if ($this->isStepCompleted($step)) {
            return $this->response()
                ->success("Langkah instalasi '{$step}' sudah selesai.");
        }

        $markStatus = $this->statusService->mark($step, 'installation', strict: true);

        if (!$markStatus) {
            return $this->response()
                ->failure("Gagal menyelesaikan langkah instalasi: '{$step}'.");
        }

        return $this->response()
            ->success("Langkah instalasi '{$step}' berhasil diselesaikan.");
    }
}
