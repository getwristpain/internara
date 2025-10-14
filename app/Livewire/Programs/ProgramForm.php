<?php

namespace App\Livewire\Programs;

use App\Services\ProgramService;
use Livewire\Attributes\On;
use Livewire\Component;

class ProgramForm extends Component
{
    public bool $readyToLoad = false;

    public array $data = [
        'name' => null,
        'year' => null,
        'semester' => null,
        'date_start' => null,
        'date_finish' => null,
        'description' => null,
    ];

    protected ProgramService $programService;

    public function boot(ProgramService $programService)
    {
        $this->programService = $programService;
    }

    #[On('init-program-form')]
    public function initialize(string|int|null $id)
    {
        $this->reset('data');
        $this->readyToLoad = false;

        if ($id) {
            $program = $this->programService->find($id);
            $this->data = array_merge([
                $this->data,
                $program->toArray()
            ]);
        }

        $this->readyToLoad = true;
    }

    public function save()
    {
        $this->validate([
            'data.name' => 'required|string|max:50|unique:programs,name,' . ($this->data['id'] ?? null),
            'data.year' => 'required|year|min:2020',
            'data.semester' => 'required|in:ganjil,genap',
            'data.date_start' => 'required|date',
            'data.date_finish' => 'required|date|after:date_start',
            'data.description' => 'nullable|string|max:1000',
        ]);

        $this->programService->save($this->data);

        notifyMe()->success('Program PKL berhasil tersimpan.');

        $this->dispatch('program-updated');
    }

    public function remove(string|int|null $id)
    {
        if (!$id) {
            notifyMe()->info('Tidak ada program PKL terhapus.');
            return true;
        }

        if (!$this->programService->delete($id)) {
            notifyMe()->error('Gagal menghapus program PKL.');
            return false;
        }

        notifyMe()->info('Program PKL telah terhapus.');
        return true;
    }

    public function render()
    {
        return view('livewire.programs.program-form');
    }
}
