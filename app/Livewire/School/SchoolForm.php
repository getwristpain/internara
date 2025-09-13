<?php

namespace App\Livewire\School;

use App\Helpers\Media;
use App\Models\School;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\SchoolService;
use Livewire\WithFileUploads;

class SchoolForm extends Component
{
    use WithFileUploads;

    protected SchoolService $service;

    public array $data = [];

    public ?string $title = null;

    public ?string $desc = null;

    public bool $bordered = false;

    public bool $shadowed = false;

    public bool $hideActions = false;

    public function __construct()
    {
        $this->service = app(SchoolService::class);
    }

    public function mount(): void
    {
        $this->initialize();
    }

    public function initialize(): void
    {
        $school = School::first();

        $this->data = array_merge(
            $school?->toArray(),
            [
                'logo' => Media::asset($school?->logo),
                'logo_file' => null
            ]
        );
    }

    #[On('school-form-submitted')]
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
            'data.logo_file' => 'sometimes|nullable|image|max:2048',
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

        if ($this->getErrorBag()->has('data.logo')) {
            $this->addError('data.logo_file', $this->getErrorBag()->first('data.logo'));
        }

        $res = $this->service->save($this->data);
        flash($res->getMessage(), $res->getStatusType());

        if ($res->passes()) {
            $this->refreshData();
            $this->dispatch('school-saved');
        }
    }

    protected function refreshData(): void
    {
        $this->reset(['data']);
        $this->resetErrorBag();

        $this->initialize();
    }

    public function render()
    {
        return view('livewire.school.school-form');
    }
}
