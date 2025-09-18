<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthService extends UserService
{
    /**
     * Authenticates a user based on credentials.
     *
     * @param array $data
     * @return LogicResponse
     */
    public function login(array $data): LogicResponse
    {
        $identifier = $data['id'] ?? $data['username'] ?? $data['email'];
        $password = $data['password'] ?? null;
        $remember = $data['remember'] ?? false;

        $key = 'login:' . Str::slug($identifier ?? '');
        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL);
        $field = $isEmail ? 'email' : 'username';

        return $this->ensureNotRateLimited($key)
            ->then(function () use ($identifier, $password, $field, $remember, $key) {
                $loggedIn = isset($data['id'])
                    ? Auth::loginUsingId($identifier, $remember)
                    : Auth::attempt([$field => $identifier, 'password' => $password], $remember);

                if ($loggedIn) {
                    session()->regenerate();
                    RateLimiter::clear($key);
                    return $this->respond(true, 'Berhasil masuk.');
                }

                return $this->respond(false, 'Kredensial tidak valid.');
            });
    }

    /**
     * Registers a new user or updates an existing one.
     *
     * @param array $data
     * @return LogicResponse
     */
    public function register(array $data): LogicResponse
    {
        $key = 'register:' . Str::slug($data['email'] ?? $data['name'] ?? '');

        // Determine roles and statuses based on the user type
        $data['roles'] = ($data['type'] ?? 'student') === 'owner'
            ? ['owner', 'admin']
            : $data['type'];

        $data['statuses'] = in_array($data['type'] ?? 'student', ['admin', 'owner'])
            ? 'protected'
            : 'pending-activation';

        return $this->ensureNotRateLimited($key)
            ->then(fn () => $this->save($data));
    }

    /**
     * Logs out the current user.
     *
     * @return LogicResponse
     */
    public function logout(): LogicResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return $this->respond(true, 'Berhasil keluar.');
    }

    /**
     * Sends a password reset link to the user's email.
     *
     * @param string $email
     * @return LogicResponse
     */
    public function sendPasswordResetLink(string $email): LogicResponse
    {
        $status = Password::sendResetLink(['email' => $email]);

        return $this->respond($status === Password::RESET_LINK_SENT, __($status));
    }

    /**
     * Resets a user's password using a token.
     *
     * @param string $email
     * @param string $token
     * @param string $newPassword
     * @param string $newPasswordConfirmation
     * @return LogicResponse
     */
    public function resetPasswordWithToken(string $email, string $token, string $newPassword, string $newPasswordConfirmation): LogicResponse
    {
        $status = Password::reset([
            'email'                 => $email,
            'token'                 => $token,
            'password'              => $newPassword,
            'password_confirmation' => $newPasswordConfirmation,
        ], function ($user) use ($newPassword) {
            $user->forceFill(['password' => $newPassword])->save();
            event(new PasswordReset($user));
        });

        return $this->respond($status === Password::PASSWORD_RESET, __($status));
    }
}
