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
            'is_installed' => false,
        ];

        return $this->firstOrInit($attributes);
    }

    public function setStatus(string $name, string $type = ''): bool
    {
        return $this->model->setStatus($name, $type);
    }

    /**
     * Check if the system is installed.
     */
    public function isInstalled(): bool
    {
        return $this->model->first()->is_installed ?? false;
    }
}
