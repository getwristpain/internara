<?php

namespace App\Livewire\Forms;

use App\Helpers\LogicResponse;
use App\Models\School;
use Livewire\Form;
use App\Models\Department;

class DepartmentForm extends Form
{
    public array $data = [
        'name' => '',
        'description' => '',
    ];

    public function submit(): LogicResponse
    {
        $this->resetValidation();
        $this->validate(
            [
                'data.name' => 'required|string|max:255|unique:departments,name',
                'data.description' => 'nullable|string|max:500',
            ],
            attributes: [
                'data.name' => 'nama jurusan',
                'data.description' => 'deskripsi jurusan'
            ]
        );

        $schoolId = School::firstOrFail()?->id;

        $department = Department::create([
            'name' => $this->data['name'],
            'description' => $this->data['description'],
            'school_id' => $schoolId,
        ]);

        $this->reset();
        return LogicResponse::make()->decide(
            (bool) $department ?? false,
            'Jurusan berhasil ditambahkan',
            'Gagal menambahkan jurusan'
        );
    }
}
