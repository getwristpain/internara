<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService extends Service
{
    protected array $permittedRoles = [
        'user',
        'owner',
        'admin',
        'staff',
        'student',
        'teacher',
        'supervisor',
    ];

    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new User);
    }

    public function register(array $data, array $roles): bool
    {
        $roles = Helper::sanitize(array_map('strtolower', $roles), $this->permittedRoles);
        $data = $this->prepareData($data, $roles[0]);
        $key = $this->throttleKey($data['identifier']);

        try {
            $this->ensureIsNotRateLimited($key);
            // TODO: Complete the registration process
        } catch (\Throwable $th) {
            $this->debug('error', 'Register failed', $th);
            throw $th;
        }

        return false;
    }

    protected function prepareData(array $data, $accountType = 'user'): array
    {
        $data['identifier'] ??= $this->generateIdentifier($accountType);

        if (isset($data['email'])) {
            $data['email'] = Str::lower($data['email']);
        }

        return $data;
    }

    protected function generateIdentifier(string $accountType = 'user'): string
    {
        do {
            $identifier = Str::lower($accountType.Number::random(8));
        } while ($this->model->where('identifier', $identifier)->exists());

        return $identifier;
    }

    public function login(array $data, string $redirectTo = '')
    {
        $email = Str::lower($data['email']);
        $remember = $data['remember'] ?? false;
        $key = $this->throttleKey($email);

        $this->ensureIsNotRateLimited($key);

        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages([
                'identifier' => ['Akun tidak valid.'],
            ]);
        }

        RateLimiter::clear($key);

        Auth::login($user, $remember);

        return redirect($redirectTo ?? route('dashboard'));
    }

    protected function throttleKey(string $identifier): string
    {
        return "login:{$identifier}";
    }

    protected function ensureIsNotRateLimited(string $key): void
    {
        $maxAttempts = 5;

        if (! RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'identifier' => ["Terlalu banyak percobaan login. Coba lagi dalam $seconds detik."],
        ]);
    }
}
