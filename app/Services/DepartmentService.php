<?php

namespace App\Services;

use App\Models\Department;
use App\Services\BaseService;

class DepartmentService extends BaseService
{
    public function getAll(): array
    {
        $departments = Department::query()
            ->orderBy("name")
            ->get();

        return $departments->map(
            fn ($dept) => $dept->only(['id', 'name', 'description']),
        )->toArray();
    }
}
