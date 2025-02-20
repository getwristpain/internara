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

    public function rules(): array
    {
        $id = parent::$attributes['id'] ?? null;

        return [
            'name' => 'required|string|max:255|unique:schools,name' . ($id ? ",$id" : ''),
            'address' => 'required|array',
            'phone' => 'required|string|max:255|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'fax' => 'required|string|max:255|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => 'required|email|max:255|unique:schools,email' . ($id ? ",$id" : ''),
            'website' => 'required|string|max:255',
            'logo' => 'required|string|max:255',
            'principal_name' => 'required|string|max:255',
        ];
    }
}
