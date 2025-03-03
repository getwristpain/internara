<?php

namespace App\Livewire\Departments;

use Livewire\Attributes\On;
use Livewire\Component;

class DepartmentSetting extends Component
{
    public bool $isDirty = false;

    public array $department = [];
    public array $departments = [];

    public function mount()
    {
        $this->init();
    }

    public function updated()
    {
        $this->isDirty = true;
    }

    public function addDepartment()
    {
        if (empty($this->department)) {
            flash()->info('Tidak ada jurusan baru yang ditambahkan.');
            return;
        }

        $this->validate([
            'department.code' => 'required|string|max:16|unique:departments,code',
            'department.name' => 'required|string|min:4|max:128',
        ]);

        $this->departments[] = $this->department;
    }

    #[On('save-departments-clicked')]
    public function save()
    {
        $this->init();
        $this->dispatch('department-setting-saved');
    }

    public function render()
    {
        return view('livewire.departments.department-setting');
    }

    protected function init()
    {
        $this->reset([
            'isDirty',
            'department',
            'departments',
        ]);

        $this->getDepartmentsData();
    }

    protected function handleDepartmentCode()
    {
        //
    }
}
