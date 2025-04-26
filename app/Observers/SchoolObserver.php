<?php

namespace App\Observers;

use App\Models\School;
use App\Models\System;

class SchoolObserver
{
    /**
     * Handle the School "created" event.
     *
     * @return void
     */
    public function created(School $school)
    {
        $this->updateSystem($school);
    }

    /**
     * Handle the School "updated" event.
     *
     * @return void
     */
    public function updated(School $school)
    {
        $this->updateSystem($school);
    }

    /**
     * Update the System data based on the School data.
     *
     * @return void
     */
    protected function updateSystem(School $school)
    {
        $system = System::first();

        if (! $system) {
            $system->create([
                'name' => $school->name,
                'logo' => $school->logo,
            ]);

            return;
        }

        $system->update([
            'name' => $school->name,
            'logo' => $school->logo,
        ]);
    }
}
