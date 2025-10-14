<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Models\Department;
use App\Services\Service;

class DepartmentService extends Service
{
    protected SchoolService $schoolService;

    public function __construct(SchoolService $schoolService)
    {
        $this->schoolService = $schoolService;
    }

    public function getAll(int $perPage = 10, bool $withoutPagination = false)
    {
        $query = Department::query()->latest();

        if ($withoutPagination) {
            return $query->get();
        }

        return $query->paginate($perPage);
    }

    public function save(array $data, ?Department $department = null)
    {
        $school = $this->schoolService->first();
        $department ??= new Department();

        try {
            $data['school_id'] ?? $school?->id;
            $department->fill($data)->save();

            return $department;
        } catch (\Throwable $th) {
            throw new AppException(
                'Gagal menyimpan data jurusan.',
                'Failed to save department: ' . $th->getMessage(),
                previous: $th
            );
        }
    }
}
