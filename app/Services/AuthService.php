<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthService extends UserService
{
    public function login(array $data)
    {
        $key = 'login:' . str($data['username'] ?? '')->lower()->slug()->toString();
        $field = filter_var($data['username'], FILTER_VALIDATE_EMAIL)
            ? 'email' : 'username';

        $login = Auth::attempt([
            $field => $data['username'],
            'password' => $data['password']
        ], $data['remember']);


        if ($login) {
            session()->regenerate();
            RateLimiter::clear($key);

            $user = auth()->user();
            $user->hasRole('owner')
                ? redirect()->intended('/admin')
                : redirect()->intended('/dashboard');
        }


        return LogicResponse::make()
            ->failWhen($this->ensureNotRateLimited($key))
            ->then(fn ($res) => $res->decide(
                $login,
                'Selamat datang kembali!',
                'Gagal untuk masuk.'
            ));
    }

    public function register(array $data): LogicResponse
    {
        $key = "register:" . str($data['email'] ?? $data['username'] ?? $data['name'] ?? '')->lower()->slug()->toString();

        return $this->response()
            ->failWhen($this->ensureNotRateLimited($key))
            ->then($this->storeUser($data));
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
