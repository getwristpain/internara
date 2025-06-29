<?php

namespace App\Services;

use App\Models\Student;
use App\Services\Service;

class StudentService extends Service
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(new Student());
    }
}
