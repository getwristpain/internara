<?php

namespace App\Livewire\Setups;

use App\Services\SetupService;
use Livewire\Component;
use Illuminate\View\View;

class DepartmentSetup extends Component
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
     * Proceeds to the next step after the department data is saved.
     *
     * @return void
     */
    public function next(): void
    {
        $res = $this->service->perform('setup:department');

        if ($res->passes()) {
            $this->redirectRoute('setup.program', navigate: true);
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
        $res = $this->service->ensureStepsCompleted('setup:school');

        if ($res->fails()) {
            flash()->error($res->getMessage());
            $this->redirectRoute('setup.school', navigate: true);
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
        $view = view('livewire.setups.department-setup');

        return $view->layout('components.layouts.guest', [
            'title' => ("Konfigurasi Jurusan Sekolah | " . config('app.description')),
        ]);
    }
}
