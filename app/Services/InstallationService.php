<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Services\Service;

class InstallationService extends Service
{
    protected StatusService $statusService;

    protected SchoolService $schoolService;

    protected DepartmentService $departmentService;

    protected OwnerService $ownerService;

    public function __construct()
    {
        parent::__construct();
    }

    public function performInstall(string $step): LogicResponse
    {
        return match ($step) {
            'welcome' => $this->installWelcome(),
            'school_config' => $this->installSchool(),
            'department_setup' => $this->installDepartment(),
            'owner_setup' => $this->installOwner(),
            'complete' => $this->installComplete(),
            default => $this->response()->failure('The specified installation step is invalid.')->storeLog()
        };
    }

    protected function installWelcome(): LogicResponse
    {
        return $this->markAsCompleted('welcome');
    }

    protected function installSchool(): LogicResponse
    {
        $firstSchool = $this->schoolService->model()->query()->first();

        if (!$firstSchool) {
            return $this->response()->failure('No school record found. Please create a school before proceeding.');
        }

        return $this->markAsCompleted('school_config');
    }

    protected function installDepartment(): LogicResponse
    {
        $department = $this->departmentService->model()->query()->first();
        if (!$department) {
            return $this->response()->failure('No department record found. Please create at least one department before proceeding.');
        }

        return $this->markAsCompleted('department_setup');
    }

    protected function installOwner(): LogicResponse
    {
        $owner = $this->ownerService->get();

        if (!$owner) {
            return $this->response()->failure('No owner or administrator found. Please create an owner or administrator before proceeding.');
        }

        return $this->markAsCompleted('owner_setup');
    }


    protected function installComplete(): LogicResponse
    {
        return $this->markAsCompleted('complete');
    }

    protected function markAsCompleted(string $step): LogicResponse
    {
        $markStatus = $this->statusService->mark($step, 'installation', strict: true);

        if (!$markStatus) {
            return $this->response()->failure("Unable to mark the installation step as completed: {$step}.");
        }

        return $this->response()->success("Installation step '{$step}' has been successfully completed.");
    }
}
