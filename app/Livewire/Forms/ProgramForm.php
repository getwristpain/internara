<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Program;
use App\Helpers\LogicResponse;

class ProgramForm extends Form
{
    public array $data = [
        'title' => '',
        'slug' => '',
        'year' => '',
        'semester' => '',
        'date_start' => '',
        'date_end' => '',
        'description' => '',
    ];

    public array $options = [];

    public function initialize()
    {
        $this->options['semester'] = [
            'ganjil' => 'Ganjil',
            'genap' => 'Genap',
        ];
    }

    public function submit(): LogicResponse
    {
        $this->validate([
            'data.title' => 'required|string|min:5|max:100|unique:programs,title',
            'data.year' => 'required|integer|min:2020',
            'data.semester' => 'required|string|in:ganjil,genap',
            'data.date_start' => 'required|date',
            'data.date_end' => 'required|date|after:date_start',
            'data.description' => 'nullable|string|max:500',
        ], attributes: [
            'data.title' => 'judul program',
            'data.slug' => 'slug program',
            'data.year' => 'tahun program',
            'data.semester' => 'semester',
            'data.date_start' => 'tanggal mulai',
            'data.date_end' => 'tanggal selesai',
            'data.description' => 'deskripsi program',
        ]);

        $createdProgram = Program::create($this->data);

        return LogicResponse::make()
            ->decide(
                (bool) $createdProgram ?? false,
                'Program berhasil ditambahkan',
                'Gagal menambahkan program'
            );
    }
}
