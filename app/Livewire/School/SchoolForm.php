<?php

namespace App\Livewire\School;

use App\Helpers\Media;
use App\Models\School;
use App\Services\SchoolService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\View\View;

class SchoolForm extends Component
{
    use WithFileUploads;

    /**
     * @var SchoolService The service to handle school data logic.
     */
    protected SchoolService $service;

    /**
     * @var School|null The school model instance.
     */
    protected ?School $school = null;

    /**
     * @var array The form data for the school.
     */
    public array $data = [];

    /**
     * @var string|null The form's title.
     */
    public ?string $title = null;

    /**
     * @var string|null The form's description.
     */
    public ?string $desc = null;

    /**
     * @var bool Determines if the form has a border.
     */
    public bool $bordered = false;

    /**
     * @var bool Determines if the form has a shadow.
     */
    public bool $shadowed = false;

    /**
     * @var bool Determines if the form actions are hidden.
     */
    public bool $hideActions = false;

    // ---

    /**
     * The Livewire component's lifecycle hook for dependency injection.
     *
     * @param SchoolService $service
     * @return void
     */
    public function boot(SchoolService $service): void
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
        $this->initialize();
    }

    /**
     * Submits the school form.
     *
     * @return void
     */
    public function submit(): void
    {
        $this->resetValidation();
        $this->validate([
            'data.name' => 'required|min:5|unique:schools,name,' . $this->data['id'],
            'data.email' => 'nullable|email|unique:schools,email,' . $this->data['id'],
            'data.telp' => 'nullable|string|min:8',
            'data.fax' => 'nullable|string|min:8',
            'data.address' => 'nullable|string',
            'data.principal_name' => 'nullable|string',
            'data.website' => 'nullable|string',
            'data.logo_url' => 'sometimes|nullable|string',
            'data.logo_file' => 'sometimes|nullable|image|mimes:jpg,png,webp|max:2048',
        ], attributes: [
            'data.name' => 'nama sekolah',
            'data.email' => 'email sekolah',
            'data.telp' => 'telp. sekolah',
            'data.fax' => 'fax. sekolah',
            'data.address' => 'alamat sekolah',
            'data.principal_name' => 'nama kepala sekolah',
            'data.website' => 'website sekolah',
            'data.logo_url' => 'logo sekolah',
            'data.logo_file' => 'logo sekolah',
        ]);

        $res = $this->service
            ->setSchool($this->school)
            ->save($this->data);

        flash($res->getMessage(), $res->getStatusType());

        if ($res->passes()) {
            $this->resetErrorBag();

            $this->initialize();
            $this->dispatch('school-form:saved');
        }
    }

    /**
     * Handles exceptions, particularly for validation errors.
     *
     * @param \Throwable $e
     * @param bool $stopPropagation
     * @return void
     */
    public function exception($e, $stopPropagation): void
    {
        if ($e instanceof ValidationException) {
            $validator = $e->validator;

            if ($validator->errors()->has('data.logo_url')) {
                $this->addError('data.logo_file', $validator->errors()->get('data.logo_url'));
            }
        }
    }

    // ---

    /**
     * Initializes the form state.
     *
     * @param bool $loadData Whether to load data from the database.
     * @return void
     */
    public function initialize(bool $loadData = true): void
    {
        $this->reset('data');

        $this->data = [
            'name' => null,
            'email' => null,
            'telp' => null,
            'fax' => null,
            'address' => null,
            'principal_name' => null,
            'website' => null,
            'logo' => null,
            'logo_file' => null,
        ];

        if ($loadData) {
            $this->loadSchoolData();
        }
    }

    /**
     * Loads existing school data if available.
     *
     * @return void
     */
    public function loadSchoolData(): void
    {
        $this->school = $this->service->get();

        if ($this->school?->exists) {
            $this->data = array_merge(
                $this->data,
                $this->school?->toArray(),
                [
                'logo' => Media::asset($this->school?->logo),
            ]
            );
        }
    }

    // ---

    /**
     * Renders the component's view with a guest layout.
     *
     * @return View
     */
    public function render(): View
    {
        /**
         * @var View $view
         */
        $view = view('livewire.school.school-form');

        return $view;
    }
}
