<?php

namespace App\Services;

use App\Helpers\LogicResponse;

/**
 * Service to handle application installation steps.
 */
class InstallationService extends Service
{
    /**
     * InstallationService constructor.
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
     * Perform the specified installation step.
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
                                        ->failure('The specified installation step is not recognized.')
                                        ->storeLog(),
        };
    }

    /**
     * Mark the welcome step as completed.
     *
     * @return LogicResponse
     */
    protected function installWelcome(): LogicResponse
    {
        return $this->markAsCompleted('welcome');
    }

    /**
     * Validate and mark the school configuration step as completed.
     *
     * @return LogicResponse
     */
    protected function installSchool(): LogicResponse
    {
        $firstSchool = $this->schoolService->model()->first();

        if (!$firstSchool) {
            return $this->response()
                ->failure("No school found. Please ensure 'School' record exists before continuing.");
        }

        return $this->markAsCompleted('school_config');
    }

    /**
     * Validate and mark the department setup step as completed.
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
                ->failure("No department found. Please ensure 'Department' record exists before continuing.");
        }

        return $this->markAsCompleted('department_setup');
    }

    /**
     * Validate and mark the owner setup step as completed.
     *
     * @return LogicResponse
     */
    protected function installOwner(): LogicResponse
    {
        $owner = $this->ownerService->model()->instance();

        if (!$owner) {
            return $this->response()
                ->failure("No owner found. Please ensure 'Owner' record exists before continuing.");
        }

        return $this->markAsCompleted('owner_setup');
    }

    /**
     * Complete the installation process.
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

    public function isStepCompleted(string $step): bool
    {
        return $this->statusService->isMarked($step, 'installation');
    }

    /**
     * Mark a specific installation step as completed.
     *
     * @param string $step
     * @return LogicResponse
     */
    protected function markAsCompleted(string $step): LogicResponse
    {
        if ($this->isStepCompleted($step)) {
            return $this->response()
                ->success("The installation step '{$step}' has already been completed.");
        }

        $markStatus = $this->statusService->mark($step, 'installation', strict: true);

        if (!$markStatus) {
            return $this->response()
                ->failure("Failed to complete the installation step: '{$step}'.");
        }

        return $this->response()
            ->success("Installation step '{$step}' completed successfully.");
    }
}
