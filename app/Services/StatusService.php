<?php

namespace App\Services;

use App\HasStatus;
use App\Models\Status;
use Illuminate\Database\Eloquent\Model;

class StatusService extends Service
{
    use HasStatus;

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new Status);
    }

    public function statusables(): ?Model
    {
        return $this->model;
    }
}
