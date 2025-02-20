<?php

namespace App\Livewire\Pages\Installations;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Welcome extends Component
{
    public function next()
    {
        $this->redirectRoute('install.school-setting', navigate: true);
    }

    public function render()
    {
        return view('livewire.pages.installations.welcome');
    }
}
