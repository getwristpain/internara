<?php

namespace App\Services;

use App\Helpers\Sanitizer;
use App\Helpers\Security;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService extends Service
{
    protected UserService $userService;

    private array $allowedActions = [
        'register',
        'login',
    ];

    protected string $action = 'register';

    protected array $user = [];

    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new User);
        $this->userService = new UserService;
    }

    private function setAction(string $action = 'register'): string
    {
        return Sanitizer::sanitize($action, 'acceptable', $this->allowedActions);
    }

    private function sanitizeUserData(array $user): array
    {
        return Sanitizer::sanitize($user, [
            'name' => 'string',
            'email' => 'email',
            'username' => 'string',
            'password' => 'string',
            'password_confirmation' => 'string',
            'status' => 'acceptabled',
            'roles' => 'acceptabled',
        ], [
            'status' => $this->model->statusOptions(),
            'roles' => $this->model->roleOptions(),
        ]);
    }

    protected function prepareData(array $user, string $action = 'register')
    {
        $this->action = $this->setAction($action);
        $this->user = $this->sanitizeUserData($user);
    }

    private function ensureIsUniqueAccount()
    {
        foreach ($this->user as $key => $value) {
            if ($key == 'email' || $key == 'username') {
                $exists = $this->exists([$key => $value]);
                if ($exists) {
                    $this->addError([
                        $key => __('validation.unique', [
                            'attribute' => $key,
                        ]),
                    ]);
                }
            }
        }
    }

    private function ensureIsPasswordHashed()
    {
        if (isset($this->user['password'])) {
            $this->user['password'] = Hash::make($this->user['password']);
        }
    }

    protected function ensureIsNotRateLimited(string $key = '')
    {
        $rateLimiter = Security::rateLimiter(
            $this->action,
            $key,
        );

        if (! $rateLimiter->check()) {
            $this->addError([
                'too_many_attempts' => __('auth.throttle', [
                    'seconds' => $rateLimiter->availableIn(),
                ]),
            ]);
        }

        return $rateLimiter->withMessages([
            'too_many_attempts' => __('auth.throttle', [
                'seconds' => $rateLimiter->availableIn(),
            ]),
        ]);
    }

    public function success(): bool
    {
        return ! $this->fails();
    }

    public function fails(): bool
    {
        return ! empty($this->getErrors());
    }

    public function register(array $user): static
    {
        $this->prepareData($user, 'register');
        $this->ensureIsNotRateLimited(request()->ip());
        $this->ensureIsUniqueAccount();
        $this->ensureIsPasswordHashed();

        if ($this->success()) {
            $this->userService->storeUser($this->user);
        }

        return $this;
    }
}
