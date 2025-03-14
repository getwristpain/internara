<?php

namespace App\Services;

use App\Models\Classroom;
use App\Services\Service;

class ClassroomService extends Service
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new Classroom);
    }
}
