<?php

namespace App\Livewire\Setups;

use App\Services\SetupService;
use Livewire\Attributes\On;
use Livewire\Component;

class AccountSetup extends Component
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
        $res = $this->service->ensureStepsCompleted('setup:welcome');
        if ($res->fails()) {
            flash()->error($res->getMessage());
            $this->redirectRoute('setup', navigate: true);
        }
    }

    #[On('register-form:owner-registered')]
    public function next(): void
    {
        $res = $this->service->perform('setup:account');
        $res->passes()
            ? $this->redirectRoute('setup.school', navigate: true)
            : flash()->error($res->getMessage());
    }

    public function render()
    {
        /**
         * @var \Illuminate\View\View $view
         */
        $view = view('livewire.setups.account-setup');
        return $view->layout('components.layouts.guest', [
            'title' => ('Buat Akun Administrator | ' . config('app.description')),
        ]);
    }
}
