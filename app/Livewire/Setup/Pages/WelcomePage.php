<?php

namespace App\Livewire\Setup\Pages;

use App\Services\SetupService;
use Livewire\Component;

class WelcomePage extends Component
{
    protected SetupService $service;

    public function __construct()
    {
        $this->service = app(SetupService::class);
    }

    public function next(): void
    {
        $res = $this->service->perform('setup:welcome');
        $res->passes() ? $this->redirectRoute('setup.account', navigate: true) : flash()->error($res->getMessage());
    }

    public function render()
    {
        /**
         * @var \Illuminate\View\View $view
         */
        $view = view('livewire.setup.pages.welcome-page');
        return $view->layout('components.layouts.guest', [
            'title' => ("Selamat Datang di | " . config('app.name'))
        ]);
    }
}
