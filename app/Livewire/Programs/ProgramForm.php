<?php

namespace App\Livewire\Programs;

use App\Models\Program;
use App\Services\ProgramService;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class ProgramForm extends Component
{
    #[Modelable]
    public ?Program $program = null;

    public array $data = [];

    public array $options = [];

    public string $fallbackTo = '';

    protected ProgramService $service;

    public function boot(): void
    {
        $this->service = app(ProgramService::class);

        $this->initialize();
    }

    public function mount(): void
    {
        $this->options['semester'] = [
            'ganjil' => 'Ganjil',
            'genap' => 'Genap',
        ];

        $this->initialize();
    }

    protected function initialize(bool $loadData = true): void
    {
        $this->reset(['data']);

        $this->data = [
            'id' => null,
            'school_id' => null,
            'title' => null,
            'year' => null,
            'semester' => null,
            'date_start' => null,
            'date_end' => null,
            'status' => null,
            'description' => null,
            'slug' => null,
        ];

        if ($loadData) {
            $this->loadProgramData();
        }
    }

    protected function loadProgramData(): void
    {
        if (isset($this->program) && $this->program?->exists) {
            $this->data = array_merge(
                $this->data,
                $this->program->toArray(),
            );
        }
    }

    public function submit(): void
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

        $res = $this->service->save($this->data, $this->program);
        flash($res->getMessage(), $res->getStatusType());

        if ($res->passes()) {
            $this->initialize();

            $this->dispatch('program-form:saved');
        }
    }

    public function remove(string|int|null $id = null): void
    {
        $removed = isset($this->program) && $this->program?->exists
            ? $this->program->delete()
            : Program::destroy($id);

        if ($removed ?? false) {
            $this->redirect($this->fallbackTo, navigate: true);
        }

    }

    public function render()
    {
        return view('livewire.programs.program-form');
    }
}
