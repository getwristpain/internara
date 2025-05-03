<?php

namespace App\Livewire\Auth\Pages;

use App\Services\AuthService;
use App\Services\SystemService;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class Login extends Component
{
    protected SystemService $systemService;

    protected AuthService $authService;

    public array $user = [];

    public function __construct()
    {
        $this->systemService = new SystemService;
        $this->authService = new AuthService;
    }

    public function login()
    {
        $this->validate([
            'user.email' => 'required|email',
            'user.password' => [
                'required',
                'string',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'user.remember' => 'boolean',
        ]);

        $this->authService->login($this->user);
    }

    public function render()
    {
        return view('livewire.auth.pages.login')
            ->extends('layouts.guest', [
                'title' => 'Masuk | '.$this->systemService->first()->name,
            ])
            ->section('content');
    }
}
