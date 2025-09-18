<?php

namespace App\Observers;

use App\Models\School;
use App\Models\Setting;

class SchoolObserver
{
    /**
     * Handle the School "created" event.
     *
     * @param School $school
     * @return void
     */
    public function created(School $school): void
    {
        $this->syncSettings($school);
    }

    /**
     * Handle the School "updated" event.
     *
     * @param School $school
     * @return void
     */
    public function updated(School $school): void
    {
        $this->syncSettings($school);
    }

    /**
     * Syncs school data with application settings.
     *
     * @param School $school
     * @return void
     */
    protected function syncSettings(School $school): void
    {
        $settings = [
            [
                'key' => 'brand_name',
                'value' => $school->name,
            ],
            [
                'key' => 'brand_logo',
                'value' => $school->getRawOriginal('logo_file'),
            ],
        ];

        // Use upsert() to perform a single, efficient database query
        Setting::upsert($settings, ['key'], ['value']);
    }
}
