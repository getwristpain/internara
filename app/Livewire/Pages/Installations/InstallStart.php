<?php

namespace App\Livewire\Pages\Installations;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class InstallStart extends Component
{
    public function next()
    {
        $this->redirect(route('install.setup-school') ?? '/', true);
    }

    public function gotoHelp()
    {
        $this->redirect(route('help'));
    }

    public function render()
    {
        return view('livewire.pages.installations.install-start');
    }
}
