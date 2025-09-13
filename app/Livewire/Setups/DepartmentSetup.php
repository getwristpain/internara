<?php

namespace App\Livewire\Setups;

use App\Services\SetupService;
use Livewire\Component;

class DepartmentSetup extends Component
{
    protected SetupService $service;

    public function __construct()
    {
        $this->service = app(SetupService::class);
    }

    public function mount(): void
    {
        $this->checkReqSteps();
    }

    protected function checkReqSteps(): void
    {
        $res = $this->service->ensureStepsCompleted('setup:school');
        if ($res->fails()) {
            flash()->error($res->getMessage());
            $this->redirectRoute('setup.school', navigate: true);
        }
    }

    public function next(): void
    {
        $res = $this->service->perform('setup:department');
        $res->passes()
            ? $this->redirectRoute('setup.program', navigate: true)
            : flash()->error($res->getMessage());
    }

    public function render()
    {
        return view('livewire.setups.department-setup');
    }
}
