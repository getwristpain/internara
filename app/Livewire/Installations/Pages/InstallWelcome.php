<?php

namespace App\Livewire\Installations\Pages;

use App\Services\InstallerService;
use Livewire\Component;

class InstallWelcome extends Component
{
    protected InstallerService $installerService;

    public function __construct()
    {
        $this->installerService = new InstallerService;
    }

    public function next()
    {
        $this->installerService->markAsCompleted('install.welcome');

        return $this->redirectRoute('install.school', navigate: true);
    }

    public function render(): mixed
    {
        return view('livewire.installations.pages.install-welcome')
            ->extends('layouts.guest', [
                'title' => 'Selamat Datang | Instalasi | '.config('app.name', 'Internara'),
            ])
            ->section('content');
    }
}
