<?php

namespace App\Livewire\Installations;

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
        return $this->installerService->checkIfCompleted('install.department') ?: $this->back();
    }

    protected function checkIfInstallOwnerCompleted()
    {
        return ! $this->installerService->checkIfCompleted('install.owner') ?: $this->next();
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
        /** @var \Livewire\Component $view */
        $view = view('livewire.installations.install-owner');

        return $view->layout('components.layouts.guest', [
            'title' => ('Konfigurasi Administrator | Instalasi | '.config('app.name')),
        ]);
    }
}
