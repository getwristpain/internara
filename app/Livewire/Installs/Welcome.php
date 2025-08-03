<?php

namespace App\Livewire\Installs;

use Livewire\Component;

class Welcome extends Component
{
    public function render()
    {
        /** @var \Illuminate\View\View $view */
        $view = view('livewire.installs.welcome');
        return $view->layout('components.layouts.guest')
            ->title('Welcome All!');
    }
}
