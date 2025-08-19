<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\School;
use App\Helpers\LogicResponse;
use App\Services\SchoolService;

class SchoolForm extends Form
{
    public array $data = [];

    public function initialize(): void
    {
        $school = School::first();
        $logoPath = $school?->logo_path ? asset($school?->logo_path) : null;

        $this->data = [
            'name' => $school?->name,
            'email' => $school?->email,
            'telp' => $school?->telp,
            'fax' => $school?->fax,
            'address' => $school?->address,
            'principal_name' => $school?->principal_name,
            'website' => $school?->website,
            'logo_path' => $logoPath,
            'logo_file' => null,
        ];
    }

    public function submit(): LogicResponse
    {
        $id = School::first()?->id;
        $this->validate([
            'data.name' => 'required|min:5|unique:schools,name,' . $id,
            'data.email' => 'nullable|email|unique:schools,email,' . $id,
            'data.telp' => 'nullable|string|min:8',
            'data.fax' => 'nullable|string|min:8',
            'data.address' => 'nullable|string',
            'data.principal_name' => 'nullable|string',
            'data.website' => 'nullable|string',
            'data.logo_path' => 'sometimes|nullable|string',
            'data.logo_file' => 'sometimes|nullable|image|max:2048',
        ], attributes: [
            'data.name' => 'nama sekolah',
            'data.email' => 'email sekolah',
            'data.telp' => 'telp. sekolah',
            'data.fax' => 'fax. sekolah',
            'data.address' => 'alamat sekolah',
            'data.principal_name' => 'nama kepala sekolah',
            'data.website' => 'website sekolah',
            'data.logo_path' => 'logo sekolah',
            'data.logo_file' => 'logo sekolah',
        ]);

        if ($this->getErrorBag()->has('data.logo_path')) {
            $this->addError('data.logo_file', $this->getErrorBag()->first('data.logo_path'));
        }

        return app(SchoolService::class)->save($this->data + ['id' => $id]);
    }
}
