<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Rules\Password;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;

class RegisterForm extends Component
{
    protected AuthService $service;

    protected User $user;

    public array $data = [];

    public string $type = 'student';

    public ?string $title = null;

    public ?string $desc = null;

    public bool $bordered = false;

    public bool $shadowed = false;

    public bool $hideActions = false;

    public function __construct()
    {
        $this->service = app(AuthService::class);
        $this->user = app(User::class);
    }

    public function mount(): void
    {
        $this->initialize($this->type);
    }

    public function initialize(string $type): void
    {
        $this->data = [
            'id' => null,
            'name' => null,
            'email' => null,
            'password' => null,
            'password_confirmation' => null,
            'type' => $type,
        ];

        if ($type === 'owner') {
            $owner = $this->user->role('owner')->first();

            $this->data['id'] = $owner?->id;
            $this->data['name'] = 'Administrator';
        }
    }

    #[On('register-form-submitted')]
    public function submit(): void
    {
        $type = $this->data['type'];

        $this->resetValidation();
        $this->validate([
            'data.name' => 'required|string|max:50',
            'data.email' => 'required|email|unique:users,email,' . $this->data['id'] ?? '',
            'data.password' => ['required', 'confirmed', Password::auto()],
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

        $res = $this->service->register($this->data);
        flash($res->getMessage(), $res->getStatusType());

        if ($res->passes()) {
            $this->refreshData();
            $this->dispatch("{$type}-registered");
        }
    }

    protected function refreshData()
    {
        $this->reset(['data']);
        $this->resetErrorBag();

        $this->initialize($this->type);
    }

    public function render()
    {
        return view('livewire.auth.register-form');
    }
}
