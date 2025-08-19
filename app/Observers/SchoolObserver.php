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
                'key' => 'app_name',
                'value' => $school->name,
                'type' => 'string',
            ],
            [
                'key' => 'app_logo',
                'value' => $school->logo_path,
                'type' => 'string',
            ]
        ];

        Setting::upsert($settings, ['key'], ['value', 'type']);
    }

    public function updated(School $school)
    {
        $settings = [
            [
                'key' => 'app_name',
                'value' => $school->name,
                'type' => 'string',
            ],
            [
                'key' => 'app_logo',
                'value' => $school->logo_path,
                'type' => 'string',
            ]
        ];

        Setting::upsert($settings, ['key'], ['value', 'type']);
    }
}
