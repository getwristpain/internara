<?php

namespace App\Livewire\Installations\Pages;

use App\Services\InstallerService;
use Livewire\Component;

class InstallDepartment extends Component
{
    protected InstallerService $installerService;

    public function __construct()
    {
        $this->installerService = new InstallerService;
        $this->installerService->isCompleted('install.school') ?: $this->back();
    }

    public function back()
    {
        return $this->redirectRoute('install.school');
    }

    public function next()
    {
        if ($this->installerService->markAsCompleted('install.departments')) {
            return $this->redirectRoute('install.owner');
        }

    }

    public function render()
    {
        return view('livewire.installations.pages.install-department')
            ->extends('layouts.guest', [
                'title' => 'Konfigurasi Jurusan dan Kelas | Instalasi | '.config('app.name'),
            ])
            ->section('content');
    }
}
