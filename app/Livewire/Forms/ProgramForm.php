<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\School;
use App\Models\Program;
use App\Helpers\LogicResponse;

class ProgramForm extends Form
{
    public array $data = [
        'id' => '',
        'title' => '',
        'year' => '',
        'semester' => '',
        'date_start' => '',
        'date_end' => '',
        'description' => '',
        'slug' => '',
    ];

    public array $options = [];

    public function initialize()
    {
        $this->data = [
            'id' => '',
            'title' => '',
            'year' => '',
            'semester' => '',
            'date_start' => '',
            'date_end' => '',
            'description' => '',
            'slug' => '',
        ];

        $this->options['semester'] = [
            'ganjil' => 'Ganjil',
            'genap' => 'Genap',
        ];
    }

    public function add(): void
    {
        $this->reset('data');
        $this->resetValidation();
    }

    public function edit($id): bool
    {
        $program = Program::find($id);
        if ($program) {
            $this->data = $program->toArray();
            return true;
        }

        return false;
    }

    public function remove($id): bool
    {

        if (Program::destroy($id)) {
            $this->reset('data');
            return true;
        }

        return false;
    }

    public function submit(): LogicResponse
    {
        $this->validate([
            'data.title' => 'required|string|min:5|max:100|unique:programs,title,' . $this->data['id'],
            'data.year' => 'required|integer|min:2020',
            'data.semester' => 'required|string|in:ganjil,genap',
            'data.date_start' => 'required|date',
            'data.date_end' => 'required|date|after:date_start',
            'data.description' => 'nullable|string|max:500',
        ], attributes: [
            'data.title' => 'judul program',
            'data.year' => 'tahun program',
            'data.semester' => 'semester',
            'data.date_start' => 'tanggal mulai',
            'data.date_end' => 'tanggal selesai',
            'data.description' => 'deskripsi program',
        ]);

        $schoolId = School::first()?->id;
        $createdProgram = Program::updateOrCreate(
            ['id' => $this->data['id']],
            array_merge([
                'school_id' => $schoolId
            ], $this->data)
        );

        return LogicResponse::make()
            ->decide(
                (bool) $createdProgram ?? false,
                'Program berhasil ditambahkan',
                'Gagal menambahkan program'
            );
    }
}
