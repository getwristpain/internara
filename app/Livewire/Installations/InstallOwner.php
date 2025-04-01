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
    }

    protected function checkIfInstallDepartmentCompleted()
    {
        return $this->installerService->checkIfCompleted('install.department') ?: $this->back();
    }

    #[On('owner-account-registered')]
    public function handleOwnerAccountRegitered()
    {
        $this->installerService->markAsCompleted('install.owner');
        $this->next();
    }

    public function next()
    {
        $this->redirectRoute('install.complete', navigate: true);
    }

    public function back()
    {
        $this->redirectRoute('install.department', navigate: true);
    }

    public function render()
    {
        /** @var \Livewire\Component $view */
        $view = view('livewire.installations.install-owner');

        return $view->layout('components.layouts.guest', [
            'title' => ('Daftar Akun Administrator | Instalasi | '.config('app.name')),
        ]);
    }
}
