<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Hash;
use Livewire\Form;
use App\Models\User;
use App\Rules\Password;
use App\Services\AuthService;
use App\Helpers\LogicResponse;

class RegisterForm extends Form
{
    public array $data = [];

    public function initialize(string $type): void
    {
        $this->data = [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
            'type' => $type,
        ];

        if ($type === 'owner') {
            $owner = User::where('type', 'owner')->first();

            $this->data['id'] = $owner?->id;
            $this->data['name'] = 'Administrator';
        }
    }

    public function submit(): LogicResponse
    {
        $this->resetValidation();
        $this->validate([
            'data.name' => 'required|string|min:5|max:250',
            'data.email' => 'sometimes|required|email|unique:users,email,' . $this->data['id'] ?? '',
            'data.username' => 'sometimes|required|string|min:5|unique:users,username,' . $this->data['id'] ?? '',
            'data.password' => ['required', 'confirmed', setting()->isDev() ? Password::bad() : Password::medium()],
            'data.type' => 'required|string|in:' . implode(',', User::getTypeOptions())
        ], attributes: [
            'data.name' => 'nama pengguna',
            'data.email' => 'email pengguna',
            'data.username' => 'username pegguna',
            'data.password' => 'kata sandi pengguna',
            'data.type' => 'tipe akun'
        ]);

        $this->data['password'] = Hash::make($this->data['password']);

        $res = app(AuthService::class)->register($this->data);
        $this->reset();

        return $res;
    }
}
