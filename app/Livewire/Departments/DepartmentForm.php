<?php

namespace App\Livewire\Departments;

use App\Helpers\Arr;
use App\Helpers\Formatter;
use App\Services\SchoolService;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class DepartmentForm extends Component
{
    protected SchoolService $schoolService;

    protected array $school = [];

    public array $departments = [];

    public array $new_department = [
        'id' => '',
        'code' => '',
        'name' => '',
        'classrooms' => [],
    ];

    public array $new_classroom = [
        'code' => '',
        'level' => '',
        'name' => '',
        'department_code' => '',
    ];

    public array $showClassrooms = [];

    public array $classroomLevelOptions = [
        ['label' => '10 (X)', 'value' => 'X'],
        ['label' => '11 (XI)', 'value' => 'XI'],
        ['label' => '12 (XII)', 'value' => 'XII'],
        ['label' => '13 (XIII)', 'value' => 'XIII'],
    ];

    public bool $showClassroomModal = false;

    public function __construct()
    {
        $this->schoolService = new SchoolService;
    }

    public function mount()
    {
        $this->init();
    }

    protected function init()
    {
        $this->school = $this->schoolService->first()->toArray();
        $this->departments = $this->school['departments'] ?? [];
        $this->showClassrooms = array_fill_keys(array_column($this->departments, 'id'), false);
    }

    public function toggleClassrooms(int $departmentId)
    {
        $this->showClassrooms[$departmentId] = ! $this->showClassrooms[$departmentId];
    }

    public function openClassroomModal(string $departmentCode)
    {
        $this->showClassroomModal = true;
        $this->new_classroom['department_code'] = $departmentCode;
    }

    #[On('modal-closed')]
    public function closeClassroomModal()
    {
        $this->showClassroomModal = false;
        $this->reset(['new_classroom']);
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'new_department.name') {
            $this->updateDepartment();
        }

        if (str_starts_with($propertyName, 'new_classroom.')) {
            $this->updateClassroom();
        }
    }

    protected function updateDepartment()
    {
        $this->new_department['code'] = $this->formatDepartmentCode($this->new_department['name']);
        $this->validate(['new_department.name' => 'required|string|unique:departments,name']);
    }

    protected function updateClassroom()
    {
        $this->new_classroom['code'] = $this->formatClassroomCode($this->new_classroom['level'], $this->new_classroom['department_code'], $this->new_classroom['name']);
        $this->validate(['new_classroom.code' => 'required|string|unique:classrooms,code']);
    }

    private function formatDepartmentCode(string $departmentName): string
    {
        return Formatter::abbrev($departmentName);
    }

    private function formatClassroomCode(string $classroomLevel, string $departmentCode, string $classroomName)
    {
        $classroomName = Formatter::abbrev($classroomName);
        $components = [$classroomLevel, $departmentCode, $classroomName];
        $filteredComponents = Arr::filter($components);

        return Str::upper(implode('-', $filteredComponents));
    }

    public function addDepartment()
    {
        $this->validate([
            'new_department.code' => 'required|string',
            'new_department.name' => 'required|string|unique:departments,name',
        ]);

        $newDepartment = [
            'id' => count($this->departments) + 1,
            'code' => $this->new_department['code'],
            'name' => $this->new_department['name'],
            'classrooms' => [],
        ];

        $this->departments[] = $newDepartment;
        $this->showClassrooms[$newDepartment['id']] = false;
        $this->storeDepartments();

        $this->reset(['new_department']);
    }

    public function addClassroom()
    {
        $this->validate([
            'new_classroom.code' => 'required|string|unique:classrooms,code',
            'new_classroom.level' => 'required|string',
            'new_classroom.name' => 'required|string',
        ]);

        foreach ($this->departments as &$department) {
            if ($department['code'] === $this->new_classroom['department_code']) {
                $newClassroom = [
                    'id' => count($department['classrooms']) + 1,
                    'code' => $this->new_classroom['code'],
                    'level' => $this->new_classroom['level'],
                    'name' => $this->new_classroom['name'],
                ];

                $department['classrooms'][] = $newClassroom;
                $this->storeDepartments();
                break;
            }
        }

        $this->closeClassroomModal();
    }

    public function deleteDepartment(int $id)
    {
        $this->schoolService->deleteDepartment($id);

        $this->departments = array_filter($this->departments, function ($department) use ($id) {
            return $department['id'] !== $id;
        });

        flash()->success('Jurusan berhasil dihapus.');
    }

    public function deleteClassroom(int $id)
    {
        $this->schoolService->deleteClassroom($id);

        foreach ($this->departments as &$department) {
            $department['classrooms'] = array_filter($department['classrooms'], function ($classroom) use ($id) {
                return $classroom['id'] !== $id;
            });
        }

        flash()->success('Kelas berhasil dihapus.');
    }

    protected function storeDepartments()
    {
        $this->schoolService->storeDepartments($this->departments);
        flash()->success('Jurusan atau Kelas berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.departments.department-form');
    }
}
