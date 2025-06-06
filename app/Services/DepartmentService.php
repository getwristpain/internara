<?php

namespace App\Services;

use App\Helpers\LogicResponse;
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

    public function getDepartments(array $where = [], array $with = []): LogicResponse
    {
        return $this->model()->get($where, $with);
    }

    public function createDepartment($attributes): LogicResponse
    {
        $department = [
            'code' => $attributes['code'],
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'school_id' => $this->schoolService()->model()->first()->then()?->id ?? null,
        ];

        $departmentResponse = $this->validate($department, [
            'code' => 'required|string|min:3|max:255|uniquie:departments,code',
            'name' => 'required|string|min:5|max:255|unique:departments,name',
            'description' => 'nullable|string|max:255',
            'school_id' => 'sometimes|required|int',
        ])->then()?->model()->create($department);

        $departmentId = $departmentResponse->payload()?->id ?? null;
        $classrooms = $attributes['classrooms'] ?? [];

        if (!empty($classrooms)) {
            $classroomResponse = $this->classroomService()->insertClassrooms($departmentId, $classrooms);

            if ($classroomResponse) {
                return $classroomResponse;
            }
        }

        return $departmentResponse;
    }

    public function insertDepartments(array $departments = []): LogicResponse
    {
        $departments = array_map(fn ($department) => [
                'code' => $department['code'] ?? '',
                'name' => $department['name'] ?? '',
                'description' => $department['description'] ?? '',
                'school_id' => $this->schoolService()->model()->first()->then()?->id ?? null
            ], $departments);

        return $this->validate(['departments' => $departments], [
                'departments.*.code' => 'required|string|min:3|max:255|uniquie:departments,code',
                'departments.*.name' => 'required|string|min:5|max:255|unique:departments,name',
                'departments.*.description' => 'nullable|string|max:255',
                'departments.*.school_id' => 'sometimes|required|int',
            ])->then()?->model()->insert($departments);
    }

    protected function schoolService(): SchoolService
    {
        return new SchoolService();
    }

    protected function classroomService(): ClassroomService
    {
        return new ClassroomService();
    }
}
