<?php

namespace App\Services;

use App\Helpers\Sanitizer;
use App\Models\System;
use Illuminate\Database\Eloquent\Collection;

class SystemService extends Service
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(new System);
    }

    public function getSystem(): System|Collection|null
    {
        $attributes = [
            'name' => config('app.name', 'Internara'),
            'version' => config('app.version', '1.0.0'),
            'logo' => config('app.logo', 'images/logo.png'),
            'is_installed' => false,
        ];

        return $this->firstOrInit($attributes);
    }

    public function setSystem(array $attributes): bool
    {
        $attributes = $this->sanitizeAttributes($attributes);
        $system = $this->first();

        if (! $system) {
            return false;
        }

        $system->update($attributes);
        $this->log('System has been updated successfully.');

        return true;
    }

    private function sanitizeAttributes(array $attributes): array
    {
        return Sanitizer::sanitize($attributes, [
            'name' => 'string',
            'version' => 'string',
            'logo' => 'string',
            'is_installed' => 'bool',
        ]);
    }

    public function isInstalled(): bool
    {
        return $this->model->first()->is_installed ?? false;
    }
}
