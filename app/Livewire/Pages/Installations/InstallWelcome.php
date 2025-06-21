<?php

namespace App\Livewire\Pages\Installations;

use App\Services\InstallationService;
use Livewire\Component;

class InstallWelcome extends Component
{
    protected InstallationService $installationService;

    public function __construct()
    {
        $this->installationService = app(InstallationService::class);
    }

    public function next(): void
    {
        $performInstall = $this->installationService->performInstall('welcome');

        if ($performInstall->fails()) {
            flash()->error($performInstall->getMessage('id'));

            $this->dispatch('install:step-error', [
                'step' => 'welcome',
                'message' => $performInstall->getMessage(),
            ]);

            return;
        }

        $this->dispatch('install:step-success', [
                'step' => 'welcome',
            ]);

        redirect()->route('install.school');
    }

    public function render()
    {
        return view('livewire.pages.installations.install-welcome');
    }
}
