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

    public function next()
    {
        if (!$this->setupService->setupWelcome()) {
            notifyMe()->error('Terjadi kesalahan saat memulai instalasi.');
            return;
        }

        session()->put('setup:welcome', true);
        $this->redirect(route('setup.account'), navigate: true);
    }

    protected function ensureIsNotInstalled()
    {
        if (setting('is_installed', true)) {
            notifyMe()->error('Tidak dapat menginstal: Aplikasi telah teristal.');

            $this->redirect(route('login'), navigate: true);
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
        $view = view('livewire.setup.setup-welcome');

        return $view->layout('components.layouts.guest', [
            'title' => ' Selamat Datang | ' . config('settings.brand_signature')
        ]);
    }
}
