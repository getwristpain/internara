<?php

namespace App\Services;

use App\Models\System;

class InstallerService extends Service
{
    protected SystemService $systemService;

    protected StatusService $statusService;

    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new System);
        $this->systemService = new SystemService;
        $this->statusService = new StatusService;
    }

    public function getSystem(): System
    {
        return $this->systemService->first();
    }

    public function markAsCompleted(string $key): bool
    {
        if ($this->isCompleted($key)) {
            return true;
        }

        return match ($key) {
            'install.welcome' => $this->setStatus('install.welcome', 'completed'),
            'install.school' => $this->setStatus('install.school', 'completed'),
            'install.departments' => $this->setStatus('install.departments', 'completed'),
            'install.owner' => $this->setStatus('install.owner', 'completed'),
            'install.system' => $this->setStatus('install.system', 'completed'),
            default => false,
        };
    }

    public function isCompleted(string $key): bool
    {
        return empty($this->statusService->firstWhere(['key' => $key, 'value' => 'completed'])) ? false : true;
    }

    protected function setStatus(string $key, string $value)
    {
        return $this->statusService->setStatus($key, $value);
    }
}
