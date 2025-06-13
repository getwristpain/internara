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
        $firstSchool = $this->service(SchoolService::class)->model()->first();

        if (!$firstSchool) {
            return $this->response()
                ->failure('No school record found. Please add a school before continuing.');
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
        $department = $this->service(SchoolService::class)
            ->model()->instance()
            ->departments()
            ->first();

        if (!$department) {
            return $this->response()
                ->failure('No department found. Please add at least one department to proceed.');
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
        $owner = $this->service(OwnerService::class)->model()->instance();

        if (!$owner) {
            return $this->response()
                ->failure('No owner found. Please create an owner account before continuing.');
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

        return $this->service(SettingService::class)->set('is_installed', true);
    }

    /**
     * Mark a specific installation step as completed.
     *
     * @param string $step
     * @return LogicResponse
     */
    protected function markAsCompleted(string $step): LogicResponse
    {
        $markStatus = $this->service(StatusService::class)->mark($step, 'installation', strict: true);

        if (!$markStatus) {
            return $this->response()
                ->failure("Failed to complete the installation step: '{$step}'.");
        }

        return $this->response()
            ->success("Installation step '{$step}' completed successfully.");
    }
}
