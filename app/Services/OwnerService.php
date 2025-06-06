<?php

namespace App\Services;

use App\Helpers\Attribute;
use App\Models\User;
use App\Services\Service;

class OwnerService extends Service
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(new User(), ['single', 'read', 'create', 'update']);
    }

    public function getOwner(): ?Attribute
    {
        return $this->model()->first(['type' => 'owner']);
    }
}
