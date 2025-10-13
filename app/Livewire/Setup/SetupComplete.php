<?php

namespace App\Livewire\Setup;

use App\Exceptions\AppException;
use App\Services\SetupService;
use Livewire\Component;

class SetupComplete extends Component
{
    protected SetupService $setupService;

    public function mount()
    {
        $this->ensureReqStepsCompleted();
    }

    public function boot(SetupService $setupService)
    {
        $this->setupService = $setupService;
    }

    public function next()
    {
        if (!$this->setupService->setupComplete()) {
            notifyMe()->error('Gagal menyelesaikan instalasi.');
            return;
        }

        session()->flush();
        $this->redirect(route('login'), navigate: true);
    }

    protected function ensureReqStepsCompleted()
    {
        if (!session('setup:program', false)) {
            notifyMe()->warning('Lengkapi langkah sebelumnya untuk melanjutkan.');

            $this->redirect(route('setup.program'), navigate: true);
            return;
        }
    }

    public function exception($e, $stopPropagation)
    {
        if ($e instanceof AppException) {
            notifyMe()->error($e->getUserMessage());
            report($e);

            $stopPropagation();
        }
    }

    public function render()
    {
        /**
         * @var \Illuminate\View\View $view
         */
        $view = view('livewire.setup.setup-complete');

        return $view->layout('components.layouts.guest', [
            'title' => 'Satu Langkah Lagi | ' . config('settings.brand_signature')
        ]);
    }
}
