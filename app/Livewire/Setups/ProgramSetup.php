<?php

namespace App\Livewire\Setups;

use App\Services\SetupService;
use Livewire\Component;

class ProgramSetup extends Component
{
    protected SetupService $service;

    public function boot(): void
    {
        $this->service = app(SetupService::class);
    }

    public function mount(): void
    {
        $this->checkReqSteps();
    }

    protected function checkReqSteps(): void
    {
        $res = $this->service->ensureStepsCompleted('setup:department');
        if ($res->fails()) {
            flash()->error($res->getMessage());
            $this->redirectRoute('setup.department', navigate: true);
        }
    }

    public function next(): void
    {
        $res = $this->service->perform('setup:program');
        $res->passes()
            ? $this->redirectRoute('setup.complete', navigate: true)
            : flash()->error($res->getMessage());
    }

    public function render()
    {
        /**
         * @var \Illuminate\View\View $view;
         */
        $view = view('livewire.setups.program-setup');
        return $view->layout('components.layouts.guest', [
            'title' => ("Konfigurasi Program PKL | " . config('app.description')),
        ]);
    }
}
