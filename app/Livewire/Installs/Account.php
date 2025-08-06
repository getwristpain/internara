<?php

namespace App\Livewire\Installs;

use App\Helpers\Transform;
use Livewire\Attributes\On;
use Livewire\Component;

class Account extends Component
{
    #[On('owner:registered')]
    public function next(): void
    {
        $this->redirectRoute('install.school');
    }

    public function render(): mixed
    {
        $title = Transform::from("Buat Akun Administrator | :app_description")
            ->replace(':app_description', config('app.description'))
            ->toString();

        /** @var \Illuminate\View\View $view */
        $view = view('livewire.installs.account');
        return $view->layout('components.layouts.guest')
            ->title($title);
    }
}
