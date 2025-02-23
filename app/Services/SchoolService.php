<?php

namespace App\Services;

use App\Models\School;
use App\Services\Service;

class SchoolService extends Service
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new School());
    }

    public function rules(array $attributes = []): array
    {
        $id = $attributes['id'] ?? $this->model?->id;

        return [
            'name' => 'required|string|max:255|unique:schools,name' . ($id ? ",$id" : ''),
            'logo_path' => 'required|string|max:255',
            'address' => 'nullable|array',
            'phone' => 'nullable|string|max:255|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'fax' => 'nullable|string|max:255|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => 'nullable|email|max:255|unique:schools,email' . ($id ? ",$id" : ''),
            'website' => 'nullable|string|max:255',
            'principal_name' => 'nullable|string|max:255',
        ];
    }

    public function getSchoolData(): School
    {
        return parent::first() ?? new School();
    }

    public function storeSchoolData(array $data)
    {
        return parent::updateOrCreate(['id' => $data['id'] ?? null], $data);
    }
}
