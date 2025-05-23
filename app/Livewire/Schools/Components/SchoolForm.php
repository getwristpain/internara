<?php

namespace App\Livewire\Schools\Components;

use App\Helpers\Uploader;
use App\Services\AddressService;
use App\Services\SchoolService;
use Livewire\Component;
use Livewire\WithFileUploads;

class SchoolForm extends Component
{
    use WithFileUploads;

    protected SchoolService $schoolService;

    protected AddressService $addressService;

    public array $school = [];

    public array $addressOptions = [];

    public bool $isDirty = false;

    public function __construct()
    {
        $this->schoolService = new SchoolService;
        $this->addressService = new AddressService;
    }

    public function mount()
    {
        $this->init();
    }

    protected function init()
    {
        $this->reset([
            'addressOptions',
            'isDirty',
            'school',
        ]);

        $this->getSchool();
        $this->getAddressOptions();
    }

    protected function getSchool()
    {
        $this->school = $this->schoolService->getSchool()->toArray();

        if (! empty($this->school['logo'])) {
            $this->school['logo_preview'] = Uploader::getPublicUrl($this->school['logo']);
        } else {
            $this->school['logo_preview'] = null;
        }
    }

    protected function getAddressOptions()
    {
        $this->addressOptions = $this->addressService->getAddressOptions($this->school['address'] ?? []);
    }

    public function updated($propertyName)
    {
        match (true) {
            ($propertyName === 'school.logo') => $this->validate(['school.logo' => 'required|image|max:1024|mimes:png,jpg,jpeg,webp']),
            str_starts_with($propertyName, 'school.address.') => $this->updateSchoolAddress($propertyName),
            default => null
        };

        $this->isDirty = true;
    }

    protected function updateSchoolAddress(string $propertyName)
    {
        match ($propertyName) {
            'school.address.province_id' => $this->updateProvince(),
            'school.address.regency_id' => $this->updateRegency(),
            'school.address.district_id' => $this->updateDistrict(),
            'school.address.subdistrict_id' => $this->updateSubdistrict(),
            default => null
        };

        $this->getAddressOptions();
    }

    protected function updateProvince()
    {
        $changedAddress = [
            'regency_id' => '',
            'district_id' => '',
            'subdistrict_id' => '',
            'postal_code' => '',
        ];

        $this->school['address'] = array_replace($this->school['address'] ?? [], $changedAddress ?? []);
    }

    protected function updateRegency()
    {
        $changedAddress = [
            'district_id' => '',
            'subdistrict_id' => '',
            'postal_code' => '',
        ];

        $this->school['address'] = array_replace($this->school['address'] ?? [], $changedAddress ?? []);
    }

    protected function updateDistrict()
    {
        $changedAddress = [
            'subdistrict_id' => '',
            'postal_code' => '',
        ];

        $this->school['address'] = array_replace($this->school['address'] ?? [], $changedAddress ?? []);
    }

    protected function updateSubdistrict()
    {
        $this->school['address']['postal_code'] = $this->addressService->getPostalCode($this->school['address'] ?? []);
    }

    public function save()
    {
        if ($this->isDirty) {
            $schoolId = $this->school['id'] ?? null;

            $this->validate(array_merge(
                [
                    'school.name' => 'required|string|max:255|unique:schools,name'.($schoolId ? ",{$schoolId}" : ''),
                    'school.address' => 'nullable|array',
                    'school.phone' => 'nullable|string|max:255|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                    'school.fax' => 'nullable|string|max:255|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                    'school.email' => 'nullable|email|max:255|unique:schools,email'.($schoolId ? ",{$schoolId}" : ''),
                    'school.website' => 'nullable|string|max:255',
                    'school.principal_name' => 'nullable|string|max:255',
                ],
                empty($this->school['logo']) ? ['school.logo' => 'required'] : []
            ));

            $this->handleSchoolLogo();
            $this->storeSchool();
        }

        $this->init();
        $this->dispatch('school-saved');
    }

    protected function handleSchoolLogo(): void
    {
        if (empty($this->school['logo'])) {
            $this->addError('school.logo', 'Logo sekolah wajib diunggah.');

            return;
        }

        if (! is_string($this->school['logo'])) {
            $this->school['logo'] = Uploader::upload($this->school['logo'], 'schools/logo');
        }

        if (empty($this->school['logo'])) {
            flash()->error('Gagal mengunggah logo sekolah.');
        }
    }

    /**
     * Store data to database
     */
    protected function storeSchool(): void
    {
        $storedData = $this->schoolService->updateOrCreate(['id' => $this->school['id'] ?? ''], $this->school);

        if (empty($storedData)) {
            flash()->error('Gagal menyimpan data sekolah.');

            return;
        }

        flash()->success('Data sekolah berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.schools.components.school-form');
    }
}
