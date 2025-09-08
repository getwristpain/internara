<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function delete(User $user, User $model): bool
    {
        if (!$model->isOwner()) {
            return true;
        }

        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        if (!$model->isOwner()) {
            return true;
        }

        return false;
    }
}
