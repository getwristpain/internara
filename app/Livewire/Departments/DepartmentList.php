<?php

namespace App\Livewire\Departments;

use App\Services\DepartmentService;
use Livewire\Component;
use App\Models\Department;

class DepartmentList extends Component
{
    protected DepartmentService $service;

    public array $departments = [];

    public array $data = [];

    public function __construct()
    {
        $this->service = app(DepartmentService::class);
    }

    public function mount(): void
    {
        $this->initialize();
    }

    protected function initialize(): void
    {
        $this->reset(['departments']);
        $this->resetErrorBag();

        $this->departments = $this->service->getAll();
        $this->data = [
            'name' => '',
            'description' => '',
        ];
    }

    public function add(): void
    {
        $this->resetValidation();
        $this->validate([
            'data.name' => 'required|string|min:5|max:50|unique:departments,name',
            'data.description' => 'sometimes|nullable|string|max:500',
        ], attributes: [
            'data.name' => 'nama jurusan',
            'data.description' => 'deskripsi jurusan',
        ]);

        $this->service->create($this->data, $res);
        $res->fails()
            ? flash()->error($res->getMessage())
            : $this->initialize();
    }

    public function remove(string|int $id): void
    {
        Department::destroy($id);
        $this->initialize();
    }

    public function render()
    {
        return view('livewire.departments.department-list');
    }
}
