<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Helpers\Uploader;
use App\Helpers\Formatter;
use Livewire\WithFileUploads;
use App\Services\SchoolService;
use App\Services\AddressService;

class SchoolSetting extends Component
{
    use WithFileUploads;

    protected SchoolService $schoolService;
    protected AddressService $addressService;

    public array $school = [];
    public array $addressOptions = [];

    public function __construct()
    {
        $this->schoolService = new SchoolService();
        $this->addressService = new AddressService();
    }

    public function mount()
    {
        $this->initData();
    }

    public function updated($propertyName)
    {
        match (true) {
            ($propertyName === 'school.logo_file') => $this->validate(['school.logo_file' => 'required|image|max:1024|mimes:png,jpg,jpeg,webp']),
            str_starts_with($propertyName, 'school.address.') => $this->updateSchoolAddress(),
            default => null,
        };
    }

    public function save()
    {
        $this->validate(array_merge(
            collect($this->schoolService->rules())
                ->mapWithKeys(fn($rule, $key) => ["school.$key" => $rule])
                ->toArray(),
            empty($this->school['logo_path']) ? ['school.logo_file' => 'required'] : []
        ));

        $this->handleSchoolLogo();
        $this->storeData();
        $this->initData();

        $this->dispatch('school-setting-saved');
    }

    public function render()
    {
        return view('livewire.settings.school-setting');
    }

    protected function initData()
    {
        $this->getSchoolData();
        $this->getAddressOptions();
    }

    protected function getSchoolData()
    {
        $schoolData = $this->schoolService->getSchoolData()->toArray();

        $this->reset('school');
        $this->school = $schoolData ?: [
            'logo_file' => '',
            'address' => [
                'province_id' => '',
                'regency_id' => '',
                'district_id' => '',
                'village_id' => '',
                'postal_code' => '',
            ]
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

    protected function updateSchoolAddress()
    {
        $districtId = $this->school['address']['district_id'] ?? '';
        $villageId = $this->school['address']['village_id'] ?? '';

        $this->getAddressOptions();
        $this->school['address']['postal_code'] = $this->addressService->getPostalCode($districtId, $villageId);
    }

    /**
     * @return void
     */
    protected function handleSchoolLogo(): void
    {
        if (isset($this->school['logo_file'])) {
            $this->school['logo_path'] = Uploader::upload($this->school['logo_file'], 'schools/logo');
            if (empty($this->school['logo_path'])) {
                flash()->error('Gagal mengunggah logo sekolah.');
            }
        }
    }

    /**
     * Store data to database
     */
    protected function storeData(): void
    {
        $storedData = $this->schoolService->storeSchoolData($this->school);
        if (empty($storedData)) {
            flash()->error('Gagal menyimpan data sekolah.');
            return;
        }

        flash()->success('Data sekolah berhasil disimpan.');
    }
}
