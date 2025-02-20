<?php

namespace App\Livewire\Installations;

use Livewire\Component;

class InstallSchool extends Component
{
    public function back()
    {
        return $this->redirectRoute('install.welcome', navigate: true);
    }

    public function render()
    {
        return view('livewire.installations.install-school');
    }
}
