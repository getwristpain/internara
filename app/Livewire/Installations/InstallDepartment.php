<?php

namespace App\Livewire\Installations;

use App\Services\InstallerService;
use Livewire\Component;

class InstallDepartment extends Component
{
    protected InstallerService $installerService;

    public function __construct()
    {
        $this->installerService = new InstallerService;
    }

    public function mount()
    {
        $this->checkIfInstallSchoolCompleted();
    }

    protected function checkIfInstallSchoolCompleted()
    {
        return $this->installerService->checkIfCompleted('install.school') ?: $this->back();
    }

    public function back()
    {
        return $this->redirectRoute('install.school', navigate: true);
    }

    public function next()
    {
        $this->installerService->markAsCompleted('install.department');

        return $this->redirectRoute('install.owner', navigate: true);
    }

    public function render()
    {
        /** @var \Livewire\Component $view */
        $view = view('livewire.installations.install-department');

        return $view->layout('components.layouts.guest', [
            'title' => ('Konfigurasi Jurusan | Instalasi | '.config('app.name', 'Internara')),
        ]);
    }
}
