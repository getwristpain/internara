<?php

namespace App\Livewire\Setup;

use App\Exceptions\AppException;
use App\Services\SetupService;
use Livewire\Component;

class DepartmentSetup extends Component
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
        if (!$this->setupService->setupDepartment()) {
            notifyMe()->error('Pastikan jurusan tersedia sebelum melanjutkan.');
            return;
        }

        session()->put('setup:department', true);
        $this->redirect(route('setup.program'));
    }

    protected function ensureReqStepsCompleted()
    {
        if (!session('setup:school', false)) {
            notifyMe()->warning('Lengkapi langkah sebelumnya untuk melanjutkan.');

            $this->redirect(route('setup.school'), navigate: true);
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
         * @var \Illuminate\View\View $view;
         */
        $view = view('livewire.setup.department-setup');

        return $view->layout('components.layouts.guest', [
            'title' => 'Atur Jurusan Sekolah | ' . config('settings.brand_signature')
        ]);
    }
}
