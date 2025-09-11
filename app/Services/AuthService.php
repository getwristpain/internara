<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\RateLimiter;

class AuthService extends UserService
{
    public function login(array $data): LogicResponse
    {
        $identifier = $data['id'] ?? $data['username'] ?? $data['email'];

        $key = 'login:' . str($identifier ?? '')->lower()->slug()->toString();
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? 'email' : 'username';

        $login = isset($data['id'])
            ? Auth::loginUsingId($identifier, $data['remember'] ?? false)
            : Auth::attempt([
                $field => $identifier,
                'password' => $data['password']
            ], $data['remember'] ?? false);

        if ((bool) $login ?? false) {
            session()->regenerate();
            RateLimiter::clear($key);
        }

        return LogicResponse::make()
            ->failWhen($this->ensureNotRateLimited($key))
            ->then(fn ($res) => $res->decide(
                (bool) $login ?? false,
                'Berhasil masuk',
                'Gagal untuk masuk'
            ));
    }

    public function register(array $data): LogicResponse
    {
        $key = "register:" . str($data['email'] ?? $data['name'] ?? '')->lower()->slug()->toString();

        return $this->response()
            ->failWhen($this->ensureNotRateLimited($key))
            ->then($this->save($data));
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
}
