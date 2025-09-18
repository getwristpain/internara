<?php

namespace App\Livewire\Setups;

use App\Services\SetupService;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class AccountSetup extends Component
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
     * Mounts the component and checks for prerequisites.
     *
     * @return void
     */
    public function mount(): void
    {
        $response = $this->service->ensureStepsCompleted('setup:welcome');

        if ($response->fails()) {
            flash()->error($response->getMessage());
            $this->redirect(route('setup'), navigate: true);
        }
    }

    /**
     * Proceed to the next step after the owner is registered.
     *
     * @return void
     */
    #[On('register-form:registered')]
    public function next(): void
    {
        $response = $this->service->perform('setup:account');

        if ($response->passes()) {
            $this->redirect(route('setup.school'), navigate: true);
        } else {
            flash()->error($response->getMessage());
        }
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
        $view = view('livewire.setups.account-setup');

        return $view->layout('components.layouts.guest', [
            'title' => 'Buat Akun Administrator | ' . config('app.description'),
        ]);
    }
}
