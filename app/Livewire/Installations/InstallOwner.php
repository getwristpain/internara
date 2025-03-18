<?php

namespace App\Livewire\Installations;

use Livewire\Component;

class InstallOwner extends Component
{
    public function back()
    {
        $this->redirectRoute('install.department', navigate: true);
    }

    public function next()
    {
        $this->redirectRoute('install.complete', navigate: true);
    }

    public function render()
    {
        return view('livewire.installations.install-owner');
    }
}
