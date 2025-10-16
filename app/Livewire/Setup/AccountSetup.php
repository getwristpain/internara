<?php

namespace App\Livewire\Setup;

use App\Services\SetupService;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class AccountSetup extends Component
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

    #[On('owner-registered')]
    public function next()
    {
        if (!$this->setupService->setupAccount()) {
            notifyMe()->error('Buat akun admin lebih dulu sebelum melanjutkan.');
            return;
        }

        session()->put('setup:account', true);
        $this->redirect(route('setup.school'), navigate: true);
    }

    protected function ensureReqStepsCompleted()
    {
        if (!session('setup:welcome', false)) {
            notifyMe()->warning('Lengkapi langkah sebelumnya untuk melanjutkan.');

            $this->redirect(route('setup'), navigate: true);
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
        $view = view('livewire.setup.account-setup');

        return $view->layout('components.layouts.guest', [
            'title' => 'Buat Akun Admin | ' . config('settings.brand_signature')
        ]);
    }
}
