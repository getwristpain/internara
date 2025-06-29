<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Models\Placement;
use App\Models\Student;
use App\Services\Service;

class PlacementService extends Service
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(new Placement());
        $this->useServices(
            StudentService::class
        );
    }

    public function registerByStudent(Student $student, array $data = []): LogicResponse
    {
        $validator = $this->performValidation($student, $data);
        if ($validator->fails()) {
            return $validator;
        }
    }

    public function performValidation(Student $student, array $data = []): LogicResponse
    {
        if ($this->hasActivePlacement($student)) {
            return $this->response()
                ->failure('Student already has an active placement.');
        }

        $validate = $this->validate([
            'program_id' => $data['program_id'] ?? $this->programService->latest('active')->id,
            'department_id' => $data['department_id'] ?? null,
            'company_id' => $data['company_id'] ?? null,
            'student_id' => $student->id,
            'teacher_id' => $data['teacher_id'] ?? null,
            'supervisor_id' => $data['supervisor_id'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'notes' => $data['notes'] ?? null,
        ], $this->rules());
        if ($validate->fails()) {
            return $validate;
        }

        return $validate;
    }

    public function rules(): array
    {
        return [
            'program_id',
            'department_id',
            'company_id',
            'student_id',
            'teacher_id',
            'supervisor_id',
            'start_date',
            'end_date',
            'notes',
        ];
    }

    protected function hasActivePlacement(Student $student): bool
    {
        return $student->placements()
            ->whereHas('statuses', function ($query) {
                $query->where(['type' => 'placement', 'value' => 'active']);
            })
            ->exists();
    }
}
