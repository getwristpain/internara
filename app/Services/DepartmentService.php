<?php

namespace App\Services;

use App\Services\Service;
use App\Models\Department;

class DepartmentService extends Service
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new Department());
    }
}
