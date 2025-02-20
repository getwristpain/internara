<?php

namespace App\Livewire\Pages\Installations;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Completion extends Component
{
    public function render()
    {
        return view('livewire.pages.installations.completion');
    }
}
