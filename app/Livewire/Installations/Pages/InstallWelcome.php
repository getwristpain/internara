<?php

namespace App\Livewire\Installations\Pages;

use App\Services\InstallerService;
use Livewire\Component;

class InstallWelcome extends Component
{
    protected InstallerService $installerService;

    public array $system = [];

    public function __construct()
    {
        $this->installerService = new InstallerService;

        $this->system = $this->installerService->getSystem()->toArray();
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
                'title' => 'Selamat Datang | Instalasi | '.$this->system['name'],
            ])
            ->section('content');
    }
}
