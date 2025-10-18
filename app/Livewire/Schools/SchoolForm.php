<?php

namespace App\Livewire\Schools;

use App\Exceptions\AppException;
use App\Services\SchoolService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class SchoolForm extends Component
{
    public bool $readyToLoad = false;

    public ?string $title = 'Data Sekolah';

    public ?string $description = 'Lengkapi data sekolah berikut dengan benar.';

    public ?string $size = 'xl';

    public bool $bordered = false;

    public array $data = [
        'name' => null,
        'principal_name' => null,
        'address' => null,
        'postal_code' => null,
        'email' => null,
        'phone' => null,
        'fax' => null,
        'website' => null,
    ];

    protected SchoolService $schoolService;

    public function boot(SchoolService $schoolService)
    {
        $this->schoolService = $schoolService;
    }

    public function initialize()
    {
        if ($this->school->exists) {
            $this->data = $this->school->toArray();
        }

        $this->readyToLoad = true;
    }

    #[Computed()]
    public function school()
    {
        return $this->schoolService->first();
    }

    #[Computed(persist: true)]
    public function schoolLogoRules()
    {
        return [
            'files.*' => 'nullable|image|mimes:jpg,png,webp|max:512'
        ];
    }

    public function save()
    {
        $this->validate([
            'data.name' => 'required|string|unique:schools,name,' . $this->school?->id,
            'data.principal_name' => 'required|string|max:50',
            'data.address' => 'required|string|max:150',
            'data.postal_code' => 'required|string|min:5',
            'data.email' => 'required|email|unique:schools,email,' . $this->school?->id,
            'data.phone' => 'required|string|min:8|unique:schools,phone,' . $this->school?->id,
            'data.fax' => 'required|string|min:8|unique:schools,fax,' . $this->school?->id,
            'data.website' => 'nullable|url',
        ], attributes: [
            'data.name' => 'nama sekolah',
            'data.principal_name' => 'nama kepala sekolah',
            'data.address' => 'alamat sekolah',
            'data.postal_code' => 'kode pos sekolah',
            'data.email' => 'email sekolah',
            'data.phone' => 'telepon sekolah',
            'data.fax' => 'fax sekolah',
            'data.website' => 'website sekolah',
        ]);

        $this->dispatch('save-attachments');
    }

    #[On('files-saved')]
    public function saving()
    {
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
