<?php

namespace App\Livewire\Programs;

use App\Models\Program;
use App\Services\ProgramService;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Illuminate\View\View;

class ProgramForm extends Component
{
    /**
     * @var Program|null The program model instance.
     */
    #[Modelable]
    public ?Program $program = null;

    /**
     * @var array The form data for the program.
     */
    public array $data = [];

    /**
     * @var array Static options for form fields.
     */
    public array $options = [];

    /**
     * @var string The fallback route for redirection.
     */
    public string $fallbackTo = '';

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
     * Mounts the component and initializes the form state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->options['semester'] = [
            'ganjil' => 'Ganjil',
            'genap' => 'Genap',
        ];

        $this->initialize();
    }

    // ---

    /**
     * Submits the program form.
     *
     * @return void
     */
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

        $response = $this->service
            ->setProgram($this->program)
            ->save($this->data);

        flash()->{$response->getStatusType()}($response->getMessage());

        if ($response->passes()) {
            $this->initialize();
            $this->dispatch('program-form:saved');
        }
    }

    /**
     * Removes the selected program.
     *
     * @param string|int|null $id
     * @return void
     */
    public function remove(string|int|null $id = null): void
    {
        $response = $this->service
            ->setProgram($this->program)
            ->delete($id);

        flash()->{$response->getStatusType()}($response->getMessage());

        if ($response->passes()) {
            $this->redirect($this->fallbackTo, navigate: true);
        }
    }

    // ---

    /**
     * Initializes the component's state and resets form data.
     *
     * @param bool $loadData Whether to load program data from the service.
     * @return void
     */
    private function initialize(bool $loadData = true): void
    {
        $this->reset(['data', 'program']);
        $this->resetErrorBag();

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

    /**
     * Loads the program data from the existing model.
     *
     * @return void
     */
    private function loadProgramData(): void
    {
        if (isset($this->program) && $this->program->exists) {
            $this->data = array_merge(
                $this->data,
                $this->program->toArray(),
            );
        }
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
        $view = view('livewire.programs.program-form');

        return $view;
    }
}
