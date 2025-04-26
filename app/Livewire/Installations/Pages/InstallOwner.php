<?php

namespace App\Livewire\Installations\Pages;

use App\Services\InstallerService;
use Livewire\Attributes\On;
use Livewire\Component;

class InstallOwner extends Component
{
    protected InstallerService $installerService;

    public function __construct()
    {
        $this->installerService = new InstallerService;
    }

    public function mount()
    {
        $this->checkIfInstallDepartmentCompleted();
        $this->checkIfInstallOwnerCompleted();
    }

    protected function checkIfInstallDepartmentCompleted()
    {
        return $this->installerService->isCompleted('install.department') ?: $this->back();
    }

    protected function checkIfInstallOwnerCompleted()
    {
        return ! $this->installerService->isCompleted('install.owner') ?: $this->next();
    }

    #[On('owner-account-registered')]
    public function handleOwnerAccountRegitered()
    {
        if ($this->installerService->markAsCompleted('install.owner')) {
            return $this->next();
        }
    }

    public function next()
    {
        $this->redirectRoute('install.complete');
    }

    public function back()
    {
        $this->redirectRoute('install.department');
    }

    public function render()
    {
        return view('livewire.installations.pages.install-owner');
    }
}
