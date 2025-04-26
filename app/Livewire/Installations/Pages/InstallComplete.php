<?php

namespace App\Livewire\Installations\Pages;

use App\Services\InstallerService;
use App\Services\SystemService;
use Livewire\Component;

class InstallComplete extends Component
{
    protected InstallerService $installerService;

    protected SystemService $systemService;

    public function __construct()
    {
        $this->installerService = new InstallerService;
        $this->systemService = new SystemService;
    }

    public function mount()
    {
        $this->checkIfInstallOwnerCompleted();
    }

    protected function checkIfInstallOwnerCompleted()
    {
        return $this->installerService->isCompleted('install.owner') ?: $this->back();
    }

    public function back()
    {
        return $this->redirectRoute('install.owner');
    }

    public function next()
    {
        if (! $this->markInstallSystemCompleted()) {
            return flash()->error('Gagal menyelesaikan instalasi sistem. Silakan coba lagi.');
        }

        return $this->redirectToLogin();
    }

    protected function markInstallSystemCompleted(): bool
    {
        $system = $this->installerService->first();

        if ($this->installerService->markAsCompleted('install.system') && $system->update(['installed' => true])) {
            return true;
        }

        return false;
    }

    protected function redirectToLogin()
    {
        return $this->redirectRoute('login');
    }

    public function render()
    {
        return view('livewire.installations.pages.install-complete');
    }
}
