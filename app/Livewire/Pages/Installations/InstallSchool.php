<?php

namespace App\Livewire\Pages\Installations;

use Livewire\Component;
use App\Services\InstallationService;

class InstallSchool extends Component
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
        if (!$this->installationService->isStepCompleted('welcome')) {
            $this->dispatch('install:step-error', [
                'step' => 'welcome',
                'message' => 'Please complete the welcome step before proceeding.',
            ]);

            $this->back();
        }
    }

    public function back(): void
    {
        redirect()->route('install.welcome');
    }

    public function next(): void
    {
        $performInstall = $this->installationService->performInstall('school_config');

        if ($performInstall->fails()) {
            flash()->error($performInstall->getMessage('id'));

            $this->dispatch('install:step-error', [
                'step' => 'school_config',
                'message' => $performInstall->getMessage(),
            ]);

            return;
        }

        $this->dispatch('install:step-success', [
                'step' => 'school_config',
                'message' => $performInstall->getMessage(),
            ]);

        redirect()->route('install.department');
    }

    public function render()
    {
        return view('livewire.pages.installations.install-school');
    }
}
