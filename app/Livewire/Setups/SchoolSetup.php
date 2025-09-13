<?php

namespace App\Livewire\Setups;

use App\Services\SetupService;
use Livewire\Attributes\On;
use Livewire\Component;

class SchoolSetup extends Component
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
        $res = $this->service->ensureStepsCompleted('setup:account');
        if ($res->fails()) {
            flash()->error($res->getMessage());
            $this->redirectRoute('setup.account', navigate: true);
        }
    }

    #[On('school-saved')]
    public function next(): void
    {
        $res = $this->service->perform('setup:school');
        $res->passes()
            ? $this->redirectRoute('setup.department', navigate: true)
            : flash()->error($res->getMessage());
    }

    public function render()
    {
        /**
         * @var \Illuminate\View\View $view
         */
        $view = view('livewire.setups.school-setup');
        return $view->layout('components.layouts.guest', [
            'title' => 'Konfigurasi Data Sekolah | ' . config('app.description'),
        ]);
    }
}
