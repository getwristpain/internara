<?php

namespace App\Livewire\Auth;

use App\Services\SystemService;
use Livewire\Component;

class ForgotPassword extends Component
{
    protected SystemService $systemService;

    public function __construct()
    {
        $this->systemService = app(SystemService::class);
    }

    public function back()
    {
        return $this->redirectRoute('login');
    }

    public function render()
    {
        $appName = $this->systemService->first()->name ?? config('app.name', 'Internara');

        return view('livewire.auth.forgot-password')
            ->layout('components.layouts.guest', [
                'title' => ('Lupa Password | '.$appName),
            ]);
    }
}
