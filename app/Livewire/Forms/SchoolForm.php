<?php

namespace App\Livewire\Forms;

use App\Services\SchoolService;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

/**
 * Class SchoolForm
 *
 * Livewire component for managing School form.
 *
 * @package App\Livewire\Forms
 */
class SchoolForm extends Component
{
    /**
     * @var array<string, mixed> School data for the form
     */
    public array $school = [];

    /**
     * @var SchoolService
     */
    protected SchoolService $schoolService;

    /**
     * Mount the component and inject dependencies.
     *
     * @param SchoolService $schoolService
     * @return void
     */
    public function mount(SchoolService $schoolService): void
    {
        $this->schoolService = $schoolService;
        $this->initialize();
    }

    /**
     * Initialize the form data.
     *
     * @return void
     */
    protected function initialize(): void
    {
        $this->school = $this->schoolService->model()->instance()?->toArray() ?? [];
    }

    public function rules(): array
    {
        return $this->schoolService->rules();
    }

    /**
     * Submit the form data.
     *
     * @return void
     */
    public function submit(): void
    {
        $this->validate();

        try {
            $this->schoolService->store($this->school);
            $this->dispatchBrowserEvent('school-stored');
        } catch (\Throwable $e) {
            Log::error('Failed to store school: ' . $e->getMessage());
            $this->addError('school', 'Failed to save school data.');
        }
    }

    /**
     * Render the Livewire component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.forms.school-form');
    }
}
