<?php

namespace App\Services;

use App\Models\User;
use App\Services\Service;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Events\Registered;
use Session;

class AuthService extends Service
{
    public function register(array $data, $user = null): User|Authenticatable
    {
        event(new Registered(($user = User::create($data))));
        Session::regenerate();

        return $user;
    }
}
