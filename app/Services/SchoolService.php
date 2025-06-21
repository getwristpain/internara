<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Models\School;

class SchoolService extends Service
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(School::first());
    }

    public function rules(): array
    {
        $id = $this->data['id'] ?? null;

        return [
            'school.name' => 'string|min:5|max:255|unique:schools,name' . (!$id ? '' : ",{$id}"),
            'school.logo_path' => 'sometimes|nullable|string|max:255',
            'school.logo_file' => 'sometimes|nullable|image|mimes:jpg,png,webp|max:20480',
            'school.address' => 'nullable|string|max:500',
            'school.email' => 'nullable|email|max:255',
            'school.phone' => 'nullable|string|max:20',
            'school.fax' => 'nullable|string|max:20',
            'school.website' => 'nullable|url|max:255',
            'school.principal_name' => 'nullable|string|max:255',
        ];
    }

    public function store(array $attributes = []): LogicResponse
    {
        return $this->response()
            ->success('Store method has not been implemented.');
    }
}
