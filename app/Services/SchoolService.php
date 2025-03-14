<?php

namespace App\Services;

use App\Models\School;
use App\Services\Service;
use App\Services\ClassroomService;
use App\Services\DepartmentService;

class SchoolService extends Service
{
    protected DepartmentService $departmentService;
    protected ClassroomService $classroomService;

    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new School);
        $this->departmentService = new DepartmentService;
        $this->classroomService = new ClassroomService;
    }

    public function first(): ?School
    {
        return $this->model->with(['departments', 'departments.classrooms'])->first() ?? new School([
            'logo' => '',
            'address' => [
                'province_id' => '',
                'regency_id' => '',
                'district_id' => '',
                'subdistrict_id' => '',
                'postal_code' => '',
            ],
        ]);
    }

    public function storeDepartments(array $data)
    {
        $this->queryCached(function () use ($data) {
            collect($data)->each(function ($departmentData) {
                $school = parent::first();

                $department = $school->departments()->updateOrCreate(
                    ['code' => $departmentData['code']],
                    [
                        'name' => $departmentData['name'],
                        'desription' => '',
                        'school_id' => $school->id,
                    ]
                );

                collect($departmentData['classrooms'])->each(function ($classroomData) use ($department) {
                    $department->classrooms()->updateOrCreate(
                        ['code' => $classroomData['code']],
                        [
                            'level' => $classroomData['level'],
                            'name' => $classroomData['name']
                        ]
                    );
                });
            });
        }, 'department', ['id' => $data['id'] ?? '']);
    }

    public function deleteDepartment(int $id)
    {
        $this->departmentService->delete($id);
    }

    public function deleteClassroom(int $id)
    {
        $this->classroomService->delete($id);
    }
}
