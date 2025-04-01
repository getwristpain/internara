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

    #[On('school-saved')]
    public function handleSchoolSaved()
    {
        $this->installerService->markAsCompleted('install.school');
        $this->next();
    }

    public function back()
    {
        return $this->redirectRoute('install', navigate: true);
    }

    public function next()
    {
        return $this->redirectRoute('install.department', navigate: true);
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
