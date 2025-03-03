<?php

namespace App\Services;

use App\Models\System;

class SystemService extends Service
{
    /*
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(new System);
    }

    public function first(): ?System
    {
        return parent::first() ?? new System([
            'name' => config('app.name', 'Internara'),
            'logo' => config('app.logo', 'images/logo.png'),
            'installed' => false,
        ]);
    }

    public function isInstalled(): bool
    {
        return $this->model?->installed ?? false;
    }
}
