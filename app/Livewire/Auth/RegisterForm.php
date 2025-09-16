<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;

class RegisterForm extends Component
{
    protected AuthService $service;

    protected ?User $user = null;

    public array $data = [];

    public string $type = 'student';

    public ?string $title = null;

    public ?string $desc = null;

    public bool $bordered = false;

    public bool $shadowed = false;

    public bool $hideActions = false;

    public function boot(): void
    {
        $this->service = app(AuthService::class);
    }

    public function mount(): void
    {
        $this->initialize();
    }

    protected function initialize(bool $loadData = true): void
    {
        $this->reset('data');
        $this->resetErrorBag();

        $this->data = [
            'name' => $this->type === 'owner' ? 'Administrator' : null,
            'email' => null,
            'password' => null,
            'password_confirmation' => null,
            'type' => $this->type,
        ];

        if ($loadData) {
            $this->loadUserData();
        }
    }

    protected function loadUserData(): void
    {
        if ($this->type === 'owner') {
            $this->user = User::query()
                ->select(['id', 'name', 'email'])
                ->role('owner')->get();

            $this->data = array_merge($this->data, $this->user?->toArray());
        }
    }

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

        $this->data['password'] = Hash::make($this->data['password']);
        $this->data['password_confirmation'] = Hash::make($this->data['password_confirmation']);

        $res = $this->service->register($this->data, $this->user);
        flash($res->getMessage(), $res->getStatusType());

        if ($res->passes()) {
            $this->initialize();
            $this->dispatch("register-form:{$type}-registered");
        }
    }

    public function render()
    {
        return view('livewire.auth.register-form');
    }

    public function exception($e, $stopPropagation)
    {
        if ($e instanceof ValidationException) {
            $validator = $e->validator;

            if ($validator->errors()->has('data.type')) {
                $this->addError('data.email', $validator->errors()->get('data.type'));
            }
        }
    }
}
