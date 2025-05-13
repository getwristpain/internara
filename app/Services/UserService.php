<?php

namespace App\Services;

use App\Models\User;

class UserService extends Service
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(new User);
    }

    public function storeUser(array $user)
    {
        $created = $this->create([$user]);
        $created->syncRoles($user['roles'] ?? []);
        $created->syncPermissions($user['permissions'] ?? []);
    }
}
