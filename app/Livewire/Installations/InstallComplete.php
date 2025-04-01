<?php

namespace App\Livewire\Installations;

use App\Services\InstallerService;
use Livewire\Component;

class InstallComplete extends Component
{
    protected InstallerService $installerService;

    public function __construct()
    {
        $this->installerService = new InstallerService;
    }

    public function mount()
    {
        $this->checkIfInstallOwnerCompleted();
    }

    protected function checkIfInstallOwnerCompleted()
    {
        return $this->installerService->checkIfCompleted('install.owner') ?: $this->back();
    }

    public function back()
    {
        return $this->redirectRoute('install.owner', navigate: true);
    }

    public function next()
    {
        $this->markInstallSystemCompleted();
        $this->login();
    }

    protected function markInstallSystemCompleted()
    {
        $system = $this->installerService->first();
        $system->update(['installed' => true]);

        $this->installerService->markAsCompleted('install.system');
    }

    protected function login()
    {
        return $this->redirectRoute('login', navigate: true);
    }

    public function render()
    {
        return view('livewire.installations.install-complete');
    }
}
