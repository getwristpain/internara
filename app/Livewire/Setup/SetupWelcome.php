<?php

namespace App\Livewire\Setup;

use App\Exceptions\AppException;
use App\Services\SetupService;
use Livewire\Component;

class SetupWelcome extends Component
{
    protected SetupService $setupService;

    public function boot(SetupService $setupService)
    {
        $this->setupService = $setupService;
    }

    public function mount()
    {
        $this->ensureIsNotInstalled();
    }

    protected function ensureIsNotInstalled()
    {
        if (setting('is_installed', true)) {
            return $this->redirect(route('login'));
        }
    }

    public function next()
    {
        if ($this->setupService->ensureIsNotInstalled()) {
            session()->put('setup:welcome');
            $this->redirect(route('setup.account'), navigate: true);

            return;
        }

        $this->dispatch('notify-me', [
            'message' => 'Tidak dapat menginstal ulang: Aplikasi telah terinstal.',
            'type' => 'warning'
        ]);
    }

    public function exception($e, $stopPropagation)
    {
        if ($e instanceof AppException) {
            $this->dispatch('notify-me', [
                'message' => $e->getUserMessage(),
                'type' => 'error'
            ]);

            report($e);
            $stopPropagation();
        }
    }

    public function render()
    {
        /**
         * @var \Illuminate\View\View $view
         */
        $view = view('livewire.setup.setup-welcome');
        return $view->layout('components.layouts.guest', [
            'title' => 'Selamat Datang di '.setting('brand_name').' | '.setting('brand_description')
        ]);
    }
}
