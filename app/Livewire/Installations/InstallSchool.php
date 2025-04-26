<?php

namespace App\Livewire\Installations;

use App\Services\InstallerService;
use Livewire\Attributes\On;
use Livewire\Component;

class InstallSchool extends Component
{
    protected InstallerService $installerService;

    public function __construct()
    {
        $this->installerService = new InstallerService;
    }

    public function mount()
    {
        $this->checkIfInstallWelcomeCompleted();
    }

    protected function checkIfInstallWelcomeCompleted()
    {
        return $this->installerService->checkIfCompleted('install.welcome') ?: $this->back();
    }

    #[On('school-saved')]
    public function handleSchoolSaved()
    {
        if ($this->installerService->markAsCompleted('install.school')) {
            return $this->next();
        }
    }

    public function back()
    {
        return $this->redirectRoute('install');
    }

    public function next()
    {
        return $this->redirectRoute('install.department');
    }

    public function render()
    {
        /** @var \Livewire\Component $view */
        $view = view('livewire.installations.install-school');

        return $view->layout('components.layouts.guest', [
            'title' => ('Konfigurasi Sekolah | Instalasi | '.config('app.name', 'Internara')),
        ]);
    }
}
