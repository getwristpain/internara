<?php

namespace App\Observers;

use App\Models\School;
use App\Models\Setting;

class SchoolObserver
{
    public function created(School $school)
    {
        $settings = [
            [
                'key' => 'brand_name',
                'value' => $school->name,
            ],
            [
                'key' => 'brand_logo',
                'value' => $school->logo_path,
            ]
        ];

        foreach ($settings as $set) {
            Setting::updateOrCreate(['key' => $set['key']], $set);
        }
    }

    public function updated(School $school)
    {
        $settings = [
            [
                'key' => 'brand_name',
                'value' => $school->name,
            ],
            [
                'key' => 'brand_logo',
                'value' => $school->logo_path,
            ]
        ];

        foreach ($settings as $set) {
            Setting::updateOrCreate(['key' => $set['key']], $set);
        }
    }
}
