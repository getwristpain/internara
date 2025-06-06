<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Models\Classroom;
use App\Services\Service;

class ClassroomService extends Service
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new Classroom());
    }

    public function getClassrooms(array $where = [], array $with = []): LogicResponse
    {
        return $this->model()->get($where, $with);
    }

    public function insertClassrooms(?int $departmentId = null, array $classrooms = []): LogicResponse
    {
        $classrooms = array_map(fn ($classroom) => [
                'code' => $classroom['code'] ?? '',
                'level' => $classroom['level'] ?? '',
                'name' => $classroom['name'] ?? '',
                'description' => $classroom['description'] ?? '',
                'department_id' => $departmentId
            ], $classrooms);


        return $this->validate(['classrooms' => $classrooms], [
                'classrooms.*.code' => 'required|string|min:3|max:255|uniquie:classrooms,code',
                'classrooms.*.level' => 'required|string|max:255',
                'classrooms.*.name' => 'required|string|min:5|max:255|unique:classrooms,name',
                'classrooms.*.description' => 'nullable|string|max:255',
                'classrooms.*.school_id' => 'sometimes|required|int',
            ])->then()?->model()->insert($classrooms);
    }
}
