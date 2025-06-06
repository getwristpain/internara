<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Helpers\Security;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService extends Service
{
    protected function __construct()
    {
        parent::__construct(new User());
    }

    public function registerOwner(array $attributes = []): LogicResponse
    {
        // Validate data
        $validatorResponse = $this->validate($attributes, [
            'name' => 'required|string|min:5|max:255',
            'email' => 'sometimes|required|email|unique:users,email',
            'username' => 'required|string|min:8|max:255|unique:users,username',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validatorResponse->fails()) {
            return $validatorResponse;
        }

        // Ensure password hashed
        $attributes['password'] = Hash::make($attributes['password']);

        // Ensure is not rate limited
        $rateLimiterResponse = Security::rateLimiter('register', 'owner')->check();
        if ($rateLimiterResponse->fails()) {
            return $rateLimiterResponse;
        }

        // Set owner
        $model = $this->model->role('owner')->first();
        $condition = !empty($model) ? ['email' => $model?->email ?? null] : [];

        $modelResponse = $this->model()->updateOrCreate($condition, $attributes);

        // Sync roles
        if ($modelResponse->success()) {
            $modelResponse->then()?->syncRoles('owner');
        }

        // return LogicResponse
        return $modelResponse;
    }
}
