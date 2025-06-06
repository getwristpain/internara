<?php

namespace App\Services;

use App\Helpers\Debugger;
use App\Helpers\LogicResponse;
use App\Services\OwnerService;
use App\Services\SchoolService;
use App\Services\Service;
use App\Services\SettingService;
use Illuminate\Support\Facades\Log;

class InstallationService extends Service
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function performInstall(string $step): ?LogicResponse
    {
        $this->ensureIsNotInstalled();

        try {
            $performInstall = match ($step) {
                'welcome' => $this->installWelcome(),
                'school_config' => $this->installSchool(),
                'department_setup' => $this->installDepartment(),
                'owner_setup' => $this->installOwner(),
                'complete' => $this->installComplete(),
                default => $this->response()
                    ->failure('Invalid installation step provided.')
                    ->withType('Installation')
                    ->storeLog()
            };
        } catch (\Throwable $th) {
            Debugger::debug($th, 'An unexpected error during application installation.');
            return null;
        }

        return $performInstall;
    }

    protected function ensureIsNotInstalled(): void
    {
        if (app(SettingService::class)->isInstalled()) {
            Log::warn('Try to access the installation routes: the application has already been installed.');

            redirect()->route('login')->with('message', 'The application has been installed.');
        }
    }

    protected function installWelcome(): LogicResponse
    {
        return $this->markAsCompleted('start', 'Welcome');
    }

    protected function installSchool(): LogicResponse
    {
        if (app(SchoolService::class)->getSchool()->isEmpty()) {
            return $this->response()->failure('School configuration must not be empty.')
                ->withType('Installation')
                ->storeLog();
        }

        return $this->markAsCompleted('school_config', 'School Configuration');
    }

    protected function installDepartment(): LogicResponse
    {
        return $this->markAsCompleted('department_setup', 'Department Setup');
    }

    protected function installOwner(): LogicResponse
    {
        if (app(OwnerService::class)->getOwner()->isEmpty()) {
            return $this->response()->failure('The owner account is required.')
                ->withType('Installation')
                ->storeLog();
        }

        return $this->markAsCompleted('owner_setup');
    }

    protected function installComplete(): LogicResponse
    {
        if (!$this->ensureStepsCompleted(['welcome', 'school_config', 'department_setup', 'owner_setup'])) {
            return $this->response()->failure('Some installation steps are missing.')
                ->withType('Installation')
                ->storelog();
        }

        $markAsCompleted = $this->markAsCompleted('complete');
        $setInstalled = app(SettingService::class)->setValues(['is_installed' => true]);

        if ($markAsCompleted->fails() || $setInstalled->fails()) {
            return $this->response()->failure('Failed to complete installation')
                ->withType('Installation')
                ->storeLog();
        }

        return $this->response()->success('Installation has been completed successfully.')
            ->withType('Installation')
            ->storeLog();
    }

    public function isStepCompleted(string $step): bool
    {
        return app(SettingService::class)->isCompleted($step, 'installation');
    }


    protected function markAsCompleted(string $name, string $label = '[label]'): LogicResponse
    {
        $completed = app(SettingService::class)->markStatus($name, 'installation', strict: true);

        if (!$completed) {
            return $this->response()->failure("Failed to complete the installation step: {$label}.")
                ->withType('Installation')
                ->storeLog();
        }

        return $this->response()->success("Installation step has been completed successfully: {$label}.")
            ->withStatus('completed')
            ->withType('Installation')
            ->storeLog();
    }

    protected function ensureStepsCompleted(array $steps = []): bool
    {
        foreach ($steps as $step) {
            if (!$this->isStepCompleted($step)) {
                return false;
            }
        }

        return true;
    }
}
