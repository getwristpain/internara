<?php

namespace App\Livewire\Pages\Installations;

use App\Services\InstallationService;
use Livewire\Component;

class InstallDepartment extends Component
{
    protected InstallationService $installationService;

    public function __construct()
    {
        $this->installationService = app(InstallationService::class);
    }

    public function mount(): void
    {
        $this->ensureRequireStepCompleted();
    }

    protected function ensureRequireStepCompleted(): void
    {
        if (!$this->installationService->isStepCompleted('school_config')) {
            $this->dispatch('install:step-error', [
                'step' => 'school_config',
                'message' => 'Please complete the school configuration step before proceeding.',
            ]);

            $this->back();
        }
    }

    public function back(): void
    {
        redirect()->route('install.school');
    }

    public function next(): void
    {
        $performInstall = $this->installationService->performInstall('department_setup');

        if ($performInstall->fails()) {
            flash()->error($performInstall->getMessage('id'));

            $this->dispatch('install:step-error', [
                'step' => 'department_setup',
                'message' => $performInstall->getMessage(),
            ]);

            return;
        }

        $this->dispatch('install:step-success', [
            'step' => 'department_setup',
            'message' => $performInstall->getMessage(),
        ]);

        redirect()->route('install.owner');
    }

    public function render()
    {
        return view('livewire.pages.installations.install-department');
    }
}
