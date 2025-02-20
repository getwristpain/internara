<?php

namespace App\Livewire\Pages\Installations;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class DepartmentClassroom extends Component
{
    public function render()
    {
        return view('livewire.pages.installations.department-classroom');
    }
}
