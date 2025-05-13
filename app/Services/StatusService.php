<?php

namespace App\Services;

use App\Models\Status;

class StatusService extends Service
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new Status);
    }
}
