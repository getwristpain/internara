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
        $this->installerService->isCompleted('install.departments') ?: $this->back();
        ! $this->installerService->isCompleted('install.owner') ?: $this->next();
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
        return $this->redirectRoute('install.complete', navigate: true);
    }

    public function back()
    {
        $this->redirectRoute('install.departments', navigate: true);
    }

    public function render()
    {
        return view('livewire.installations.pages.install-owner')
            ->extends('layouts.guest', [
                'title' => 'Konfigurasi Administrator | Instalasi | '.config('app.name'),
            ])
            ->section('content');
    }
}
