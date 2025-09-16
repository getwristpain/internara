<?php

namespace App\Livewire\School;

use App\Helpers\Media;
use App\Models\School;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use App\Services\SchoolService;
use Livewire\WithFileUploads;

class SchoolForm extends Component
{
    use WithFileUploads;

    protected SchoolService $service;

    protected ?School $school = null;

    public array $data = [];

    public ?string $title = null;

    public ?string $desc = null;

    public bool $bordered = false;

    public bool $shadowed = false;

    public bool $hideActions = false;

    public function boot(): void
    {
        $this->service = app(SchoolService::class);
    }

    public function mount(): void
    {
        $this->initialize();
    }

    public function initialize(bool $loadData = true): void
    {
        $this->reset('data');
        $this->resetErrorBag();

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
            'data.logo' => 'sometimes|nullable|string',
            'data.logo_file' => 'sometimes|nullable|image|mimes:jpg,png,webp|max:2048',
        ], attributes: [
            'data.name' => 'nama sekolah',
            'data.email' => 'email sekolah',
            'data.telp' => 'telp. sekolah',
            'data.fax' => 'fax. sekolah',
            'data.address' => 'alamat sekolah',
            'data.principal_name' => 'nama kepala sekolah',
            'data.website' => 'website sekolah',
            'data.logo' => 'logo sekolah',
            'data.logo_file' => 'logo sekolah',
        ]);

        $res = $this->service->save($this->data, $this->school);
        flash($res->getMessage(), $res->getStatusType());

        if ($res->passes()) {
            $this->initialize();
            $this->dispatch('school-form:saved');
        }
    }

    public function render()
    {
        return view('livewire.school.school-form');
    }

    public function exception($e, $stopPropagation)
    {
        if ($e instanceof ValidationException) {
            $validator = $e->validator;

            if ($validator->errors()->has('data.logo')) {
                $this->addError('data.logo_file', $validator->errors()->get('data.logo'));
            }
        }
    }
}
