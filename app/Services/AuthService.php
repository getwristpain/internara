<?php

namespace App\Services;

use Session;
use App\Models\User;
use App\Services\Service;
use Illuminate\Support\Str;
use App\Services\UserService;
use App\Exceptions\AppException;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
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
            $user = new User();
            if ($type === 'owner') {
                $user = $user->role('owner')->first();
            }

            $this->ensureNotRateLimited('register');
            $this->ensureUserHasRole($data, $type);

            $regiteredUser = $this->userService->save($data, $user);
            $regiteredUser->syncRoles($data['roles']);

            event(new Registered($regiteredUser));

            return $regiteredUser;
        } catch (\Throwable $th) {
            throw new AppException(
                'Gagal mendaftarkan akun pengguna.',
                'Failed to register user: ' . $th->getMessage()
            );
        }
    }

    public function ensureUserHasRole(array &$data, string $type = 'student'): void
    {
        $type = Str::title($type);
        $data['roles'] = $type === 'Owner' ? ['Owner', 'Admin'] : [$type];
    }
}
