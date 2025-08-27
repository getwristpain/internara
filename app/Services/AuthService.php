<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Helpers\Transform;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\PasswordResetLinkSent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthService extends BaseService
{
    public function register(array $data): LogicResponse
    {
        $key = "register:" . $data['email'];
        return $this->response()
            ->failWhen($this->ensureNotRateLimited($key))
            ->then($this->createUser($data));
    }

    public function sendPasswordResetLink(string $email): LogicResponse
    {
        $status = Password::sendResetLink([
            'email' => $email
        ]);

        return $this->response()
            ->make(
                $status === Password::RESET_LINK_SENT,
                __($status),
            );
    }

    public function resetPasswordWithToken(string $email, string $token, string $newPassword, string $newPasswordConfirmation): LogicResponse
    {
        $status = Password::reset([
            'email' => $email,
            'token' => $token,
            'password' => $newPassword,
            'password_confirmation' => $newPasswordConfirmation
        ], function ($user) use ($newPassword) {
            $this->ensurePasswordHashed($newPassword);
            $user->forceFill([
                'password' => $newPassword
            ])->save();

            event(new PasswordReset($user));
        });

        return $this->response()
            ->make(
                $status === Password::PASSWORD_RESET,
                __($status)
            );
    }

    protected function createUser(array $data): LogicResponse
    {
        $this->ensureUsernameFilled($data['username'], $data['email'], $data['id']);
        $this->ensurePasswordHashed($data['password']);

        $ownerId = User::where('type', 'owner')->first()?->id ?? '';
        $storedUser = $data['type'] === 'owner'
            ? User::updateOrCreate(['id' => $ownerId], $data)
            : User::create($data);

        return $this->response()->decide(
            (bool) $storedUser ?? false,
            'Akun pengguna berhasil dibuat.',
            'Gagal menyimpan akun pengguna.'
        );
    }

    protected function ensureUsernameFilled(?string &$ref, ?string $default, string|int|null $id = null): void
    {
        $ref ??= $default;

        $validator = Validator::make(
            data: ['username' => $ref],
            rules: ['username' => 'required|string|min:5|unique:users,username,' . $id],
            attributes: ['username' => 'username pengguna']
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function ensurePasswordHashed(?string &$ref): void
    {
        if (!str_starts_with($ref, '$2y$')) {
            $ref = Hash::make($ref);
        }
    }

    protected function ensureNotRateLimited(string $key, int $maxAttempts = 5): LogicResponse
    {
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $message = Transform::from("Terlalu banyak percobaan mendaftar akun. Tunggu hingga :seconds detik.")
                ->replace(':seconds', RateLimiter::avaliableIn($key))
                ->toString();

            return $this->response()->error($message);
        }

        RateLimiter::increment($key);
        return $this->response()->success();
    }
}
