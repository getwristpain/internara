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
     * Get the system record.
     */
    public function getSystem()
    {
        $attributes = [
            'name' => config('app.name', 'Internara'),
            'version' => config('app.version', '1.0.0'),
            'logo' => config('app.logo', 'images/logo.png'),
            'installed' => false,
        ];

        if (! $this->isInstalled()) {
            return new System($attributes);
        }

        return parent::firstOrInit(attributes: $attributes);
    }

    /**
     * Check if the system is installed.
     */
    public function isInstalled(): bool
    {
        return System::first()->installed ?? false;
    }
}
