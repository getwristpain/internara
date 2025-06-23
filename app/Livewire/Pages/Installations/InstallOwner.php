<?php

namespace App\Livewire\Pages\Installations;

use App\Services\InstallationService;
use Livewire\Component;

class InstallOwner extends Component
{
    protected InstallationService $installationService;

    public function __construct()
    {
        $this->installationService = app(InstallationService::class);
    }

    public function mount(): void
    {
        $this->ensureRequireStepCompleted();
        $this->checkIfOwnerSetupCompleted();
    }

    protected function ensureRequireStepCompleted(): void
    {
        if (!$this->installationService->isStepCompleted('department_setup')) {
            $this->dispatch('install:step-error', [
                'step' => 'department_setup',
                'message' => 'Please complete the department setup step before proceeding.',
            ]);

            $this->back();
        }
    }

    protected function checkIfOwnerSetupCompleted(): void
    {
        if ($this->installationService->isStepCompleted('owner_setup')) {
            $this->dispatch('install:step-error', [
                'step' => 'department_setup',
                'message' => 'Please complete the department setup step before proceeding.',
            ]);

            redirect()->route('install.complete');
        }
    }

    public function back(): void
    {
        redirect()->route('install.department');
    }

    public function next(): void
    {
        $performInstall = $this->installationService->performInstall('owner_setup');

        if ($performInstall->fails()) {
            flash()->error($performInstall->getMessage('id'));

            $this->dispatch('install:step-error', [
                'step' => 'owner_setup',
                'message' => $performInstall->getMessage(),
            ]);

            return;
        }

        $this->dispatch('install:step-success', [
            'step' => 'owner_setup',
            'message' => $performInstall->getMessage(),
        ]);

        redirect()->route('install.complete');
    }

    public function render()
    {
        return view('livewire.pages.installations.install-owner');
    }
}
