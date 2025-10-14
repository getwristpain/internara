<?php

namespace App\Livewire\Setup;

use App\Exceptions\AppException;
use App\Services\SetupService;
use Livewire\Component;

class ProgramSetup extends Component
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
        if (!$this->setupService->setupProgram()) {
            notifyMe()->error('Pastikan program PKL tersedia sebelum melanjutkan.');
            return;
        }

        session()->put('setup:program', true);
        $this->redirect(route('setup.complete'), navigate: true);
    }

    protected function ensureReqStepsCompleted()
    {
        if (!session('setup:department', false)) {
            notifyMe()->warning('Lengkapi langkah sebelumnya untuk melanjutkan.');

            $this->redirect(route('setup.department'), navigate: true);
            return;
        }
    }

    public function exception($e, $stopPropagation)
    {
        if ($e instanceof AppException) {
            notifyMe()->error($e->getUserMessage());
            report($e);

            $stopPropagation();
        };
    }

    public function render()
    {
        /**
         * @var \Illuminate\View\View $view
         */
        $view = view('livewire.setup.program-setup');

        return $view->layout('components.layouts.guest', [
            'Atur Program PKL | ' . config('settings.brand_signature')
        ]);
    }
}
