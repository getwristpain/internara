<?php

namespace App\Livewire\Setups;

use App\Services\SetupService;
use Livewire\Component;
use Illuminate\View\View;

class ProgramSetup extends Component
{
    /**
     * @var SetupService The service to handle setup logic.
     */
    protected SetupService $service;

    // ---

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
     * Mounts the component and checks for required preceding steps.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->checkReqSteps();
    }

    // ---

    /**
     * Proceeds to the next step after the program data is saved.
     *
     * @return void
     */
    public function next(): void
    {
        $res = $this->service->perform('setup:program');

        if ($res->passes()) {
            $this->redirectRoute('setup.complete', navigate: true);
        } else {
            flash()->error($res->getMessage());
        }
    }

    // ---

    /**
     * Checks if the required previous setup steps have been completed.
     *
     * @return void
     */
    private function checkReqSteps(): void
    {
        $res = $this->service->ensureStepsCompleted('setup:department');

        if ($res->fails()) {
            flash()->error($res->getMessage());
            $this->redirectRoute('setup.department', navigate: true);
        }
    }

    // ---

    /**
     * Renders the component's view with a guest layout.
     *
     * @return View
     */
    public function render(): View
    {
        /**
         * @var View $view
         */
        $view = view('livewire.setups.program-setup');

        return $view->layout('components.layouts.guest', [
            'title' => ("Konfigurasi Program PKL | " . config('app.description')),
        ]);
    }
}
