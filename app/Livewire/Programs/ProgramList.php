<?php

namespace App\Livewire\Programs;

use App\Models\Program;
use App\Services\ProgramService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class ProgramList extends Component
{
    public Collection|null $programs = null;

    public ?Program $selectedProgram = null;

    public bool $showProgramFormModal = false;

    protected ProgramService $service;

    public function boot(): void
    {
        $this->service = app(ProgramService::class);
    }

    public function mount(): void
    {
        $this->initialize();
    }

    public function initialize(): void
    {
        $this->selectedProgram = null;
        $this->programs = Program::query()->latest()->get();
    }

    public function openProgramFormModal(string|int|null $id = null): void
    {
        $this->selectedProgram = null;

        if (isset($id)) {
            $this->selectedProgram = $this->programs->where('id', $id)->first();
        }

        $this->showProgramFormModal = true;
    }

    #[On('program-form:saved')]
    public function closeProgramFormModal(): void
    {
        $this->initialize();
        $this->showProgramFormModal = false;

        $this->reset('selectedProgram');
    }

    public function render()
    {
        return view('livewire.programs.program-list');
    }
}
