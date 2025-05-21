<?php

namespace App\Services;

use App\Models\System;

class InstallerService extends Service
{
    protected SystemService $systemService;

    protected StatusService $statusService;

    protected SchoolService $schoolService;

    protected DepartmentService $departmentService;

    protected AuthService $authService;

    private string $statusType = 'installation';

    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new System);
        $this->systemService = new SystemService;
        $this->statusService = new StatusService;
    }

    protected function markAsCompleted(string $name): bool
    {
        return $this->model->markStatus($name, $this->statusType);
    }

    public function performInstall(array $data, string $step = 'welcome'): bool
    {
        return match ($step) {
            'welcome' => $this->installWelcome(),
            'school_config' => $this->installSchool($data),
            'department_setup' => $this->installDepartment($data),
            'owner_setup' => $this->installOwner($data),
            default => false,
        };
    }

    public function installWelcome(): bool
    {
        return $this->markAsCompleted('welcome');
    }

    public function installSchool(array $data): bool
    {
        if (! $this->schoolService->setSchool($data)) {
            return false;
        }

        return $this->markAsCompleted('school_config');
    }

    public function installDepartment(array $data): bool
    {

        return $this->markAsCompleted('department_setup');
    }
}
