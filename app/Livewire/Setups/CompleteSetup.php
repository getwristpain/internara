<?php

namespace App\Livewire\Setups;

use App\Services\SetupService;
use Livewire\Component;

class CompleteSetup extends Component
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
        $res = $this->service->ensureStepsCompleted('setup:program');
        if ($res->fails()) {
            flash()->error($res->getMessage());
            $this->redirectRoute('setup.program', navigate: true);
        }
    }

    public function next(): void
    {
        $res = $this->service->perform('setup:complete');
        $res->passes()
            ? $this->redirectRoute('login', navigate: true)
            : flash()->error($res->getMessage());
    }

    public function render()
    {
        /**
         * @var \Illuminate\\View\View $view
         */
        $view = view('livewire.setups.complete-setup');
        return $view->layout('components.layouts.guest', [
            'title' => ('Satu Langkah Lagi | ' . config('app.description')),
        ]);
    }
}
