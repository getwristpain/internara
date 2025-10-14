<?php

namespace App\Services;

use App\Models\User;
use App\Services\Service;
use App\Services\UserService;
use App\Exceptions\AppException;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Events\Registered;

class AuthService extends Service
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(array $data, string $type = 'student'): User|Authenticatable
    {
        try {
            $this->ensureNotRateLimited('register');

            $regiteredUser = $this->userService->create($data, $type);

            if ($type !== 'owner' || $type !== 'admin') {
                event(new Registered($regiteredUser));
            }

            return $regiteredUser;
        } catch (\Throwable $th) {
            throw new AppException(
                'Gagal mendaftarkan akun pengguna.',
                'Failed to register user: ' . $th->getMessage()
            );
        }
    }
}
