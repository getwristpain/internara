<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\User;
use App\Services\AuthService;
use App\Helpers\LogicResponse;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginForm extends Form
{
    public array $data = [
        'username' => '',
        'password' => '',
        'remember' => ''
    ];

    public function submit(): LogicResponse
    {
        $this->resetErrorbag();
        $this->resetValidation();

        $this->validate([
            'data.username' => 'required|string',
            'data.password' => 'required|string'
        ]);

        $res = app(AuthService::class)->login($this->data);

        if ($res->fails()) {
            $this->addError(
                'data.username',
                'Kombinasi email/username atau password salah.'
            );
        }

        return $res;
    }
}
