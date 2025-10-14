<?php

namespace App\Livewire\Programs;

use App\Services\ProgramService;
use Livewire\Attributes\On;
use Livewire\Component;

class ProgramList extends Component
{
    public bool $showProgramFormModal = false;

    protected ProgramService $programService;

    public function boot(ProgramService $programService)
    {
        $this->programService = $programService;
    }

    public function programs()
    {
        return $this->programService->getAll();
    }

    #[On('program-updated')]
    public function syncPrograms()
    {
        unset($this->programs);
    }

    public function toggleProgramFormModal(string|int|null $id = null)
    {
        $this->dispatch('init-program-form', id: $id);
        $this->showProgramFormModal = !$this->showProgramFormModal;
    }

    public function render()
    {
        return view('livewire.programs.program-list');
    }
}
