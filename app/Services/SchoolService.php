<?php

namespace App\Services;

use App\Helpers\Sanitizer;
use App\Models\School;

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

    public function getSchool(): ?School
    {
        $school = $this->first(['departments', 'departments.classrooms']);

        if ($school && empty($school->address)) {
            $school->address = [
                'province_id' => '',
                'regency_id' => '',
                'district_id' => '',
                'subdistrict_id' => '',
                'postal_code' => '',
            ];
        }

        return $school ?? new School([
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

    protected function prepareSchoolData(array $school): array
    {
        $school = Sanitizer::sanitize($school, [
            'name' => 'string',
            'logo' => 'string',
            'address' => 'array',
            'email' => 'email',
            'phone' => 'string',
            'fax' => 'string',
            'website' => 'string',
            'principal_name' => 'string',
        ]);

        return $school;
    }

    public function setSchool(array $school)
    {
        $school = $this->prepareSchoolData($school);
    }

    public function storeDepartments(array $data)
    {
        return collect($data)->each(function ($departmentData) {
            $school = $this->first();

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
                        'name' => $classroomData['name'],
                    ]
                );
            });
        });
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
