<?php

namespace App\Livewire\Schools;

use App\Exceptions\AppException;
use App\Services\SchoolService;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SchoolForm extends Component
{
    public array $data = [
        'name' => null,
        'principal_name' => null,
        'address' => null,
        'postal_code' => null,
        'email' => null,
        'phone' => null,
        'fax' => null,
        'website' => null,
        'logo_url' => null,
        'logo_file' => null,
    ];

    protected SchoolService $schoolService;

    public function boot(SchoolService $schoolService)
    {
        $this->schoolService = $schoolService;
    }

    public function initialize()
    {
        if ($this->school->exists) {
            $this->data = array_merge([
                $this->data,
                $this->school->toArray()
            ]);
        }
    }

    #[Computed()]
    public function school()
    {
        return $this->schoolService->firstSchool();
    }

    public function submit()
    {
        if (empty($this->data['logo_file'])) {
            unset($this->data['logo_url']);
        }

        $this->validate([
            'data.name' => 'required|string|unique:schools,name,' . $this->school?->id,
            'data.principal_name' => 'required|string|max:50',
            'data.address' => 'required|array',
            'data.postal_code' => 'required|string|min:5',
            'data.email' => 'required|email|unique:schools,email,' . $this->school?->id,
            'data.phone' => 'required|string|min:8|max:15|unique:schools,phone,' . $this->school?->id,
            'data.fax' => 'required|string|min:8|max:15|unique:schools,fax,' . $this->school?->id,
            'data.website' => 'nullable|url',
            'data.logo_url' => 'sometimes|nullable|url',
            'data.logo_file' => 'sometimes|nullable|image|mimes:png,svg|max:512',
        ], attributes: [
            'data.name' => null,
            'data.principal_name' => null,
            'data.address' => null,
            'data.postal_code' => null,
            'data.email' => null,
            'data.phone' => null,
            'data.fax' => null,
            'data.website' => null,
            'data.logo_url' => null,
            'data.logo_file' => null,
        ]);

        $savedSchool = $this->schoolService->save($this->data);
        if ($savedSchool) {
            $this->data = array_merge([
                $this->data,
                $savedSchool->toArray()
            ]);

            notifyMe()->success('Berhasil menyimpan data sekolah.');
            $this->dispatch('school-updated');
        }
    }

    public function exception($e, $stopPropagation)
    {
        if ($e instanceof AppException) {
            notifyMe()->error($e->getUserMessage());
            report($e);

            $stopPropagation();
        }
    }

    public function render()
    {
        return view('livewire.schools.school-form');
    }
}
