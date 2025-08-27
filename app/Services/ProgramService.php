<?php

namespace App\Services;

use App\Models\Program;
use App\Services\BaseService;

class ProgramService extends BaseService
{
    public function getAll(): array
    {
        return Program::all()
            ->toArray();
    }
}
