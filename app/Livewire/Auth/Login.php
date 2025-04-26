<?php

namespace App\Livewire\Auth;

use App\Services\SystemService;
use Livewire\Component;

class Login extends Component
{
    protected SystemService $systemService;

    public function __construct()
    {
        $this->systemService = app(SystemService::class);
    }

    public function render()
    {
        $appName = $this->systemService->first()->name ?? '';

        return view('livewire.auth.login')
            ->layout('components.layouts.guest', [
                'title' => "Login | {$appName}",
            ]);
    }
}
