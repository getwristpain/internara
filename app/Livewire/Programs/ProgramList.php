<?php

namespace App\Livewire\Programs;

use App\Services\ProgramService;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Program;
use Illuminate\View\View;

class ProgramList extends Component
{
    /**
     * @var Collection|null The list of programs fetched from the service.
     */
    public ?Collection $programs = null;

    /**
     * @var Program|null The selected program for editing.
     */
    public ?Program $selectedProgram = null;

    /**
     * @var bool Controls the visibility of the program form modal.
     */
    public bool $showProgramFormModal = false;

    /**
     * @var ProgramService The service to handle program data logic.
     */
    protected ProgramService $service;

    // ---

    /**
     * The Livewire component's lifecycle hook for dependency injection.
     *
     * @param ProgramService $service
     * @return void
     */
    public function boot(ProgramService $service): void
    {
        $this->service = $service;
    }

    /**
     * Mounts the component and initializes the list data.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->initialize();
    }

    // ---

    /**
     * Opens the program form modal and loads data for the selected program.
     *
     * @param string|int|null $id The ID of the program to edit.
     * @return void
     */
    public function openProgramFormModal(string|int|null $id = null): void
    {
        $this->selectedProgram = null;

        if (isset($id)) {
            $this->selectedProgram = $this->service->get($id);
        }

        $this->showProgramFormModal = true;
    }

    /**
     * Closes the program form modal and re-initializes the list data.
     *
     * @return void
     */
    #[On('program-form:saved')]
    public function closeProgramFormModal(): void
    {
        $this->initialize();
        $this->showProgramFormModal = false;
    }

    // ---

    /**
     * Initializes the component's state by fetching all programs.
     *
     * @return void
     */
    private function initialize(): void
    {
        $this->selectedProgram = null;
        $this->programs = $this->service->getAll();
    }

    // ---

    /**
     * Renders the component's view.
     *
     * @return View
     */
    public function render(): View
    {
        /**
         * @var View $view
         */
        $view = view('livewire.programs.program-list');

        return $view;
    }
}
