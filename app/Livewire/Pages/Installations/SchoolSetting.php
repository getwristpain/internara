<?php

namespace App\Livewire\Pages\Installations;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')]
class SchoolSetting extends Component
{
    public function render()
    {
        return view('livewire.pages.installations.school-setting');
    }
}
