<?php

namespace App\Observers;

use App\Models\School;
use App\Models\Setting;

class SchoolObserver
{
    /**
     * Handle the School "created" event.
     *
     * @return void
     */
    public function created(School $school): void
    {
        $this->updateSetting($school);
    }

    /**
     * Handle the School "updated" event.
     *
     * @return void
     */
    public function updated(School $school): void
    {
        $this->updateSetting($school);
    }

    /**
     * Update the System data based on the School data.
     *
     * @return void
     */
    protected function updateSetting(School $school): void
    {
        $setting = Setting::first();

        if (! $setting) {
            $setting->create([
                'app_name' => $school->name ?? '',
                'logo_path' => $school->logo_path ?? '',
            ]);

            return;
        }

        $setting->update([
            'app_name' => $school->name ?? '',
            'logo_path' => $school->logo_path ?? '',
        ]);
    }
}
