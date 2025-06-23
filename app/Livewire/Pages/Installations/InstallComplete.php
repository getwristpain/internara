<?php

namespace App\Livewire\Pages\Installations;

use App\Services\InstallationService;
use Livewire\Component;

class InstallComplete extends Component
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
        if (!$this->installationService->isStepCompleted('owner_setup')) {
            $this->dispatch('install:step-error', [
                'step' => 'owner_setup',
                'message' => 'Please complete the owner setup step before proceeding.',
            ]);

            $this->back();
        }
    }

    public function back(): void
    {
        redirect()->route('install.owner');
    }

    public function next(): void
    {
        $performInstall = $this->installationService->performInstall('complete');

        if ($performInstall->fails()) {
            flash()->error($performInstall->getMessage('id'));

            $this->dispatch('install:step-error', [
                'step' => 'complete',
                'message' => $performInstall->getMessage(),
            ]);

            return;
        }

        $this->dispatch('install:step-success', [
            'step' => 'complete',
            'message' => $performInstall->getMessage(),
        ]);

        redirect()->route('auth.login');
    }

    public function render()
    {
        return view('livewire.pages.installations.install-complete');
    }
}
