<?php

namespace App\Services;

use App\Models\School;

class SchoolService extends Service
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(School::first());
    }
}
