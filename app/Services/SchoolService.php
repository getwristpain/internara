<?php

namespace App\Services;

use App\Helpers\Attribute;
use App\Helpers\LogicResponse;
use App\Models\School;
use Illuminate\Database\Eloquent\Collection;

class SchoolService extends Service
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new School(), ['single', 'read', 'update']);
    }

    public function getSchool(): ?Attribute
    {
        return $this->model()->first();
    }

    public function setSchool(array $attributes = []): LogicResponse
    {
        return $this->validate($attributes, [
            'name' => 'required|string|min:5|max:255',
            'logo' => 'sometimes|nullable|string',
            'logo_path' => 'sometimes|nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|min:10',
            'fax' => 'nullable|string|min:10',
            'website' => 'nullable|url|max:255',
            'principal_name' => 'nullable|string|min:5|max:255',
            'address_id' => 'nullable|integer',
        ])->then()?->model()->set([
            'name' => $attributes['name'],
            'logo' => $attributes['logo_path'] ?? $attributes['logo'],
            'email' => $attributes['email'],
            'phone' => $attributes['phone'],
            'fax' => $attributes['fax'],
            'website' => $attributes['website'],
            'principal_name' => $attributes['principal_name'],
            'address_id' => $attributes['address_id']
        ]);
    }

    public function storeSchool(array $attributes = []): LogicResponse
    {
        return $this->response()->success('School has been stored successfully.')
            ->withType($this->type)
            ->storeActivity()
            ->storeLog();
    }
}
