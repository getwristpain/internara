<?php

namespace App\Livewire\Installations\Pages;

use App\Services\InstallerService;
use Livewire\Attributes\On;
use Livewire\Component;

class InstallSchool extends Component
{
    protected InstallerService $installerService;

    public function __construct()
    {
        $this->installerService = new InstallerService;
        $this->installerService->isCompleted('install.welcome') ?: $this->back();
    }

    #[On('school-saved')]
    public function handleSchoolSaved()
    {
        $this->installerService->markAsCompleted('install.school');

        return $this->next();
    }

    public function back()
    {
        return $this->redirectRoute('install', navigate: true);
    }

    public function next()
    {
        return $this->redirectRoute('install.departments', navigate: true);
    }

    public function render()
    {
        return view('livewire.installations.pages.install-school')
            ->extends('layouts.guest', [
                'title' => 'Konfigurasi Sekolah | Instalasi | '.config('app.name', 'Internara'),
            ])
            ->section('content');
    }
}
