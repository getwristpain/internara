<?php

namespace App\Livewire\Installations;

use Livewire\Attributes\{Title, Layout};
use Livewire\Component;

#[Title('Selamat Datang')]
#[Layout('components.layouts.guest')]
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
