<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService extends Service
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new User);
    }

    public function register(array $data, array $roles): bool
    {
        $data['password'] = Hash::make($data['password']);

        if (in_array($roles, ['owner'])) {
            return $this->updateOrCreate($data)->syncRoles($roles) ? true : false;
        }

        return $this->create($data)->syncRoles($roles) ? true : false;
    }
}
