<?php

namespace App\Services;

use App\Models\School;
use App\Helpers\Helper;
use App\Models\Department;
use App\Services\BaseService;
use App\Helpers\LogicResponse;
use Illuminate\Database\Eloquent\Collection;

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

    public function create(array $data, ?LogicResponse &$response = null): ?Department
    {
        $data['school_id'] ??= School::first()?->id;

        $created = Department::create(Helper::filterFillable($data, Department::class));
        $response = $this->response()->decide(
            (bool) $created ?? false,
            'Berhasil menambahkan jurusan.',
            'Gagal menambahkan jurusan.'
        );

        return $created;
    }
}
