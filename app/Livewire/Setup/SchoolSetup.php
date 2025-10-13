<?php

namespace App\Livewire\Setup;

use App\Exceptions\AppException;
use App\Services\SetupService;
use Livewire\Attributes\On;
use Livewire\Component;

class SchoolSetup extends Component
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

    #[On('school-updated')]
    public function next()
    {
        if (!$this->setupService->setupSchool()) {
            notifyMe()->error('Lengkapi data sekolah lebih dulu sebelum melanjutkan.');
            return;
        }

        session()->put('setup:school', true);
        $this->redirect(route('setup.department'), navigate: true);
    }

    protected function ensureReqStepsCompleted()
    {
        if (!session('setup:account', false)) {
            notifyMe()->warning('Lengkapi langkah sebelumnya untuk melanjutkan.');

            $this->redirect(route('setup.account'), navigate: true);
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
        $view = view('livewire.setup.school-setup');

        return $view->layout('components.layouts.guest', [
            'title' => 'Konfigurasi Sekolah | ' . config('settings.brand_signature'),
        ]);
    }
}
