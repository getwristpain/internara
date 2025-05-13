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

    protected function setStatus(string $name)
    {
        return $this->systemService->setStatus($name, $this->statusType);
    }

    public function getSystem(): System
    {
        return $this->systemService->getSystem();
    }

    public function installWelcome(): bool
    {
        return $this->setStatus('welcome');
    }

    public function installSchool(array $school = []): bool
    {
        $this->schoolService->setSchool($school);

        return $this->setStatus('school_config');
    }
}
