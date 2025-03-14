<?php

namespace App\Livewire\Installations;

use Livewire\Attributes\On;
use Livewire\Component;

class InstallSchool extends Component
{
    public function back()
    {
        return $this->redirectRoute('install', navigate: true);
    }

    #[On('school-setting-saved')]
    public function next()
    {
        return $this->redirectRoute('install.department', navigate: true);
    }

    public function render()
    {
        return view('livewire.installations.install-school')
            ->layout('components.layouts.guest', [
                'title' => ('Konfigurasi Sekolah | Instalasi | '.config('app.name', 'Internara')),
            ]);
    }
}
