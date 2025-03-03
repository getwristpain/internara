<?php

namespace App\Livewire\Settings;

use App\Helpers\Formatter;
use App\Helpers\Uploader;
use App\Services\AddressService;
use App\Services\SchoolService;
use Livewire\Component;
use Livewire\WithFileUploads;

class SchoolSetting extends Component
{
    use WithFileUploads;

    protected SchoolService $schoolService;

    protected AddressService $addressService;

    public bool $isDirty = false;

    public array $school = [];

    public array $addressOptions = [];

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

        $this->getSchoolData();
        $this->getAddressOptions();
    }

    protected function getSchoolData()
    {
        $schoolData = $this->schoolService->first()?->toArray() ?? null;

        if (! empty($schoolData['logo'])) {
            $schoolData['logo_preview'] = Uploader::getPublicUrl($schoolData['logo']);
        }

        $this->reset('school');
        $this->school = $schoolData ?? [
            'logo' => '',
            'address' => [
                'province_id' => '',
                'regency_id' => '',
                'district_id' => '',
                'village_id' => '',
                'postal_code' => '',
            ],
        ];
    }

    protected function getAddressOptions()
    {
        $this->addressOptions = [
            'provinces' => Formatter::formatOptions($this->addressService->getProvinces()->toArray()),
            'regencies' => Formatter::formatOptions($this->addressService->getRegencies($this->school['address']['province_id'] ?? '')->toArray()),
            'districts' => Formatter::formatOptions($this->addressService->getDistricts($this->school['address']['regency_id'] ?? '')->toArray()),
            'villages' => Formatter::formatOptions($this->addressService->getVillages($this->school['address']['district_id'] ?? '')->toArray()),
        ];

        return $this->addressOptions ?? [];
    }

    public function updated($propertyName)
    {
        match (true) {
            ($propertyName === 'school.logo') => $this->validate(['school.logo' => 'required|image|max:1024|mimes:png,jpg,jpeg,webp']),
            str_starts_with($propertyName, 'school.address.') => $this->updateSchoolAddress(),
            default => null,
        };

        $this->isDirty = true;
    }

    protected function updateSchoolAddress()
    {
        $districtId = $this->school['address']['district_id'] ?? '';
        $villageId = $this->school['address']['village_id'] ?? '';

        $this->getAddressOptions();
        $this->school['address']['postal_code'] = $this->addressService->getPostalCode($districtId, $villageId);
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
            $this->storeData();
        }

        $this->init();
        $this->dispatch('school-setting-saved');
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
    protected function storeData(): void
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
        return view('livewire.settings.school-setting');
    }
}
