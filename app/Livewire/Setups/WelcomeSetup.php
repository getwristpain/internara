<?php

namespace App\Livewire\Setups;

use App\Services\SetupService;
use Livewire\Component;
use Illuminate\View\View;

class WelcomeSetup extends Component
{
    /**
     * @var SetupService The service to handle setup logic.
     */
    protected SetupService $service;

    /**
     * The Livewire component's lifecycle hook for dependency injection.
     *
     * @param SetupService $service
     * @return void
     */
    public function boot(SetupService $service): void
    {
        $this->service = $service;
    }

    /**
     * Proceeds to the next step of the setup process.
     *
     * @return void
     */
    public function next(): void
    {
        $response = $this->service->perform('setup:welcome');

        $response->passes()
            ? $this->redirect(route('setup.account'), navigate: true)
            : flash()->error($response->getMessage());
    }

    /**
     * Renders the component's view.
     *
     * @return View
     */
    public function render(): View
    {
        /**
         * @var View $view
         */
        $view = view('livewire.setups.welcome-setup');

        return $view->layout('components.layouts.guest', [
                'title' => 'Selamat Datang | ' . config('app.description')
            ]);
    }
}
