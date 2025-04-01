<?php

namespace App\Livewire\Auth;

use App\Services\AuthService;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class RegisterOwnerForm extends Component
{
    protected AuthService $authService;

    public array $owner = [];

    public array $defaultRoles = ['owner', 'admin'];

    public function __construct()
    {
        $this->authService = new AuthService;
    }

    public function registerOwner()
    {
        $this->validate([
            'owner.name' => 'required|string|min:5',
            'owner.email' => 'required|email|unique:users,email',
            'owner.password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        $registered = $this->authService->register($this->owner, $this->defaultRoles);
        if (! $registered) {
            return flash()->error('Gagal membuat akun administrator.');
        }

        $this->reset(['owner']);

        flash()->success('Akun administrator berhasil dibuat.');
        $this->dispatch('owner-account-registered');
    }

    public function render()
    {
        return view('livewire.auth.register-owner-form');
    }
}
