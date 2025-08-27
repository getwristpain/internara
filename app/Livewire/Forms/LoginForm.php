<?php

namespace App\Livewire\Forms;

use App\Helpers\LogicResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    public array $data = [
        'username' => '',
        'password' => '',
        'remember' => ''
    ];

    protected string $field = 'email';

    public function submit()
    {
        $this->resetErrorbag();
        $this->resetValidation();

        $this->validate([
            'data.username' => 'required|string',
            'data.password' => 'required|string'
        ]);

        $this->field = filter_var($this->data['username'], FILTER_VALIDATE_EMAIL)
            ? 'email' : 'username';

        $login = Auth::attempt([
            $this->field => $this->data['username'],
            'password' => $this->data['password']
        ], $this->data['remember']);

        $login
            ? session()->regenerate()
            : $this->addError(
                'data.username',
                "Kombinasi email/username atau password salah."
            );

        return LogicResponse::make()
            ->decide(
                $login,
                'Selamat datang kembali!',
                'Gagal untuk masuk.'
            );
    }
}
