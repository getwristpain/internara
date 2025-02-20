<?php

namespace App\Livewire\Pages\Installations;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class OwnerSetup extends Component
{
    public function render()
    {
        return view('livewire.pages.installations.owner-setup');
    }
}
