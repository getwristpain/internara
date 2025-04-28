<?php

namespace App\Services;

use App\Models\System;

class SystemService extends Service
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(new System);
    }

    /**
     * Get the first system record.
     */
    public function first(): System
    {
        if (! $this->isInstalled()) {
            return new System([
                'name' => config('app.name', 'Internara'),
                'version' => config('app.version', '1.0.0'),
                'logo' => config('app.logo', 'images/logo.png'),
                'installed' => false,
            ]);
        }

        return parent::first() ?? new System([
            'name' => config('app.name', 'Internara'),
            'version' => config('app.version', '1.0.0'),
            'logo' => config('app.logo', 'images/logo.png'),
            'installed' => false,
        ]);
    }

    /**
     * Check if the system is installed.
     */
    public function isInstalled(): bool
    {
        $system = System::first();

        return $system->installed ?? false;
    }
}
