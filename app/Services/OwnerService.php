<?php

namespace App\Services;

use App\Models\User;
use App\Services\Service;
use Illuminate\Database\Eloquent\Model;

class OwnerService extends Service
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(User::where(['type' => 'owner'])->first());
    }

    public function get(): ?Model
    {
        return $this->model()?->instance();
    }
}
