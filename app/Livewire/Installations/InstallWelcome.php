<?php

namespace App\Livewire\Installations;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Selamat Datang')]
class InstallWelcome extends Component
{
    public function next()
    {
        return $this->redirectRoute('install.school', navigate: true);
    }

    public function render()
    {
        return view('livewire.installations.install-welcome');
    }
}
