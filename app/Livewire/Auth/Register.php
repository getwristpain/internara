<?php

namespace App\Livewire\Auth;

use App\Exceptions\AppException;
use App\Rules\Password;
use App\Services\AuthService;
use App\Services\UserService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Register extends Component
{
    public bool $readyToLoad = false;

    #[Locked()]
    public string $type = 'student';

    public array $data = [
        'name' => null,
        'email' => null,
        'password' => null,
        'password_confirmation' => null,
    ];

    protected AuthService $authService;

    protected UserService $userService;

    public function boot(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function initialize()
    {
        if ($this->type === 'owner') {
            $this->data['name'] = 'Administrator';
        }

        $this->readyToLoad = true;
    }

    #[Computed(persist: true)]
    public function owner()
    {
        if ($this->type === 'owner') {
            return $this->userService->getOwner();
        }

        return null;
    }

    public function submit()
    {
        $this->validate(
            [
                'data.name' => 'required|string|min:5|max:50',
                'data.email' => 'required|email|unique:users,email,' . $this->owner?->id,
                'data.password' => ['required', 'confirmed', Password::auto()],
            ],
            attributes: [
                'data.name' => 'nama pengguna',
                'data.email' => 'email pengguna',
                'data.password' => 'kata sandi pengguna',
                'data.password_confirmation' => 'konfirmasi kata sandi',
            ],
        );

        $this->authService->register($this->data, $this->type);
        $this->dispatch("{$this->type}-registered");
    }

    public function exception($e, $stopPropagation)
    {
        if ($e instanceof AppException) {
            notifyMe()->error($e->getUserMessage());
            report($e);

            $stopPropagation();
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
