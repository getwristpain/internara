<?php

namespace App\Services;

use App\Models\School;

class SchoolService extends Service
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new School);
    }

    public function first(): ?School
    {
        return parent::first() ?? new School([
            'logo' => '',
            'address' => [
                'province_id' => '',
                'regency_id' => '',
                'district_id' => '',
                'subdistrict_id' => '',
                'postal_code' => '',
            ],
        ]);
    }
}
