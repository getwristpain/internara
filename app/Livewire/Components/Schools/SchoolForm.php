<?php

namespace App\Livewire\Components\Schools;

use App\Helpers\Formatter;
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

    public function __construct()
    {
        $this->schoolService = new SchoolService();
        $this->addressService = new AddressService();
    }

    protected function init()
    {
        $this->school = $this->schoolService->first() ?? [
            'logo' => '',
            'address' => [
                'province_id' => '',
                'regency_id' => '',
                'district_id' => '',
                'village_id' => '',
                'postal_code' => '',
            ]
        ];
        $this->getAddressOptions();
    }

    protected function getAddressOptions()
    {
        $this->reset('addressOptions');

        $this->addressOptions = [
            'provinces' => Formatter::formatOptions($this->addressService->getProvinces()->toArray()),
            'regencies' => Formatter::formatOptions($this->addressService->getRegencies($this->school['address']['province_id'] ?? '')->toArray()),
            'districts' => Formatter::formatOptions($this->addressService->getDistricts($this->school['address']['regency_id'] ?? '')->toArray()),
            'villages' => Formatter::formatOptions($this->addressService->getVillages($this->school['address']['district_id'] ?? '')->toArray()),
        ];

        return $this->addressOptions;
    }

    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'school.address.')) {
            $this->getAddressOptions();
            $this->school['address']['postal_code'] = $this->addressService->getPostalCode($this->school['address']['village_id'] ?? '');
        }
    }

    public function mount()
    {
        $this->init();
    }

    public function back()
    {
        return $this->redirectRoute('install', navigate: true);
    }

    public function next()
    {
        $this->validate(['school' => $this->schoolService->rules()]);
        $this->schoolService->create($this->school);
        return $this->redirectRoute('install.department-classroom', navigate: true);
    }

    public function render()
    {
        return view('livewire.components.schools.school-form');
    }
}
