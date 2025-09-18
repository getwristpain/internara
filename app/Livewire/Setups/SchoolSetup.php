<?php

namespace App\Livewire\Setups;

use App\Services\SetupService;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\View\View;

class SchoolSetup extends Component
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
        $response = $this->service->ensureStepsCompleted('setup:account');

        if ($response->fails()) {
            flash()->error($response->getMessage());
            $this->redirect(route('setup.account'), navigate: true);
        }
    }

    /**
     * Proceeds to the next step after the school data is saved.
     *
     * @return void
     */
    #[On('school-form:saved')]
    public function next(): void
    {
        $response = $this->service->perform('setup:school');

        if ($response->passes()) {
            $this->redirect(route('setup.department'), navigate: true);
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
        $view = view('livewire.setups.school-setup');

        return $view->layout('components.layouts.guest', [
            'title' => 'Konfigurasi Data Sekolah | ' . config('app.description'),
        ]);
    }
}
