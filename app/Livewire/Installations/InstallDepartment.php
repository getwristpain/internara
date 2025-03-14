<?php

namespace App\Livewire\Installations;

use Livewire\Attributes\On;
use Livewire\Component;

class InstallDepartment extends Component
{
    public function back()
    {
        return $this->redirectRoute('install.school', navigate: true);
    }

    public function next()
    {
        return $this->redirectRoute('install.owner', navigate: true);
    }

    public function render()
    {
        return view('livewire.installations.install-department')
            ->layout('components.layouts.guest', [
                'title' => ('Konfigurasi Jurusan | Instalasi | ' . config('app.name', 'Internara')),
            ]);
    }
}
