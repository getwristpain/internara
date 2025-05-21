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

    public function setSchool(array $attributes): bool
    {
        $attributes = $this->sanitizeAttributes($attributes);

        return $this->updateFirst($attributes);
    }

    protected function sanitizeAttributes(array $attributes): array
    {
        return Sanitizer::sanitize($attributes, [
            'name' => 'string',
            'logo' => 'string',
            'address' => 'array',
            'email' => 'email',
            'phone' => 'string',
            'fax' => 'string',
            'website' => 'string',
            'principal_name' => 'string',
        ]);
    }
}
