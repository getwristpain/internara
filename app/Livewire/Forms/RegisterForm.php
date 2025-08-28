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
            'name' => null,
            'email' => null,
            'password' => null,
            'password_confirmation' => null,
            'type' => $type,
        ];

        if ($type === 'owner') {
            $owner = User::role('owner')->first();

            $this->data['id'] = $owner?->id;
            $this->data['name'] = 'Administrator';
        }
    }

    public function submit(): LogicResponse
    {
        $this->resetValidation();
        $this->validate([
            'data.name' => 'required|string|min:5|max:250',
            'data.email' => 'required|email|unique:users,email,' . $this->data['id'] ?? '',
            'data.password' => ['required', 'confirmed', setting()->isDev() ? Password::bad() : Password::medium()],
            'data.type' => 'required|string|in:' . implode(',', User::getRolesOptions())
        ], attributes: [
            'data.name' => 'nama pengguna',
            'data.email' => 'email pengguna',
            'data.password' => 'kata sandi pengguna',
            'data.type' => 'tipe pengguna',
        ]);

        if ($this->getErrorBag()->has('data.type')) {
            $this->addError('data.name', $this->getErrorBag()->get('data.type')->first());
        }

        $this->data['password'] = Hash::make($this->data['password']);
        $this->data['password_confirmation'] = Hash::make($this->data['password_confirmation']);

        $res = app(AuthService::class)->register($this->data);
        $this->reset();

        return $res;
    }
}
