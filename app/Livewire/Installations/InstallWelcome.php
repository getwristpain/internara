<?php

namespace App\Livewire\Installations;

use Livewire\Component;

class InstallWelcome extends Component
{
    public function next()
    {
        return $this->redirectRoute('install.school', navigate: true);
    }

    public function render()
    {
        return view('livewire.installations.install-welcome')
            ->layout('components.layouts.guest', [
                'title' => ('Selamat datang di '.config('app.name', 'Internara')),
            ]);
    }
}
