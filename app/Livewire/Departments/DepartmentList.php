<?php

namespace App\Livewire\Departments;

use App\Services\DepartmentService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\View\View;
use Livewire\Attributes\On;

class DepartmentList extends Component
{
    use WithPagination;

    /**
     * @var DepartmentService The service to handle department data logic.
     */
    protected DepartmentService $service;

    /**
     * @var array The list of departments fetched from the service.
     */
    public array $departments = [];

    /**
     * @var array The form data for adding a new department.
     */
    public array $data = [];

    // ---

    /**
     * The Livewire component's lifecycle hook for dependency injection.
     *
     * @param DepartmentService $service
     * @return void
     */
    public function boot(DepartmentService $service): void
    {
        $this->service = $service;
    }

    /**
     * Mounts the component and initializes the form and list data.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->initialize();
    }

    // ---

    /**
     * Creates a new department based on the form data.
     *
     * @return void
     */
    public function add(): void
    {
        $this->resetValidation();
        $this->validate([
            'data.name' => 'required|string|min:5|max:50|unique:departments,name',
            'data.description' => 'sometimes|nullable|string|max:500',
        ], attributes: [
            'data.name' => 'nama jurusan',
            'data.description' => 'deskripsi jurusan',
        ]);

        $response = $this->service->create($this->data);

        if ($response->passes()) {
            flash()->success($response->getMessage());
            $this->initialize();
        } else {
            flash()->error($response->getMessage());
        }
    }

    /**
     * Removes a department.
     *
     * @param string|int $id
     * @return void
     */
    public function remove(string|int $id): void
    {
        $response = $this->service->delete($id);

        if ($response->passes()) {
            flash()->success($response->getMessage());
            $this->initialize();
        } else {
            flash()->error($response->getMessage());
        }
    }

    // ---

    /**
     * Initializes the component's state and resets form data.
     *
     * @param bool $loadData Whether to load department data from the service.
     * @return void
     */
    private function initialize(bool $loadData = true): void
    {
        $this->reset('data');
        $this->resetErrorBag();

        $this->data = [
            'name' => '',
            'description' => '',
        ];

        if ($loadData) {
            $this->loadDeptData();
        }
    }

    /**
     * Loads the list of departments from the service.
     *
     * @return void
     */
    private function loadDeptData(): void
    {
        $this->departments = $this->service->getAll();
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
        $view = view('livewire.departments.department-list');

        return $view;
    }
}
