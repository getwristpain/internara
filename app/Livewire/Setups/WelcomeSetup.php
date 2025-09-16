<?php

namespace App\Livewire\Setups;

use App\Services\SetupService;
use Livewire\Component;

class WelcomeSetup extends Component
{
    protected SetupService $service;

    public function boot(): void
    {
        $this->service = app(SetupService::class);
    }

    public function next(): void
    {
        $res = $this->service->perform('setup:welcome');
        $res->passes()
            ? $this->redirectRoute('setup.account', navigate: true)
            : flash()->error($res->getMessage());
    }

    public function render(): mixed
    {
        /**
         * @var \Illuminate\View\View $view
         */
        $view = view('livewire.setups.welcome-setup');
        return $view->layout('components.layouts.guest', [
                'title' => ('Selamat Datang | ' . config('app.description'))
            ]);
    }
}
