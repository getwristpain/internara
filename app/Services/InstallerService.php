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

    public function markAsCompleted(string $key)
    {
        try {
            match ($key) {
                'install.school' => $this->setStatus('install.school', 'completed'),
                'install.department' => $this->setStatus('install.department', 'completed'),
                'install.owner' => $this->setStatus('install.owner', 'completed'),
                'install.system' => $this->setStatus('install.system', 'completed'),
                default => $this->debug('error', 'Invalid key provided.'),
            };
        } catch (\Throwable $th) {
            $this->debug('error', $th->getMessage(), $th);
            throw $th;
        }
    }

    public function checkIfCompleted(string $key): bool
    {
        return empty($this->statusService->firstWhere(['key' => $key, 'value' => 'completed'])) ? false : true;
    }

    protected function setStatus(string $key, string $value)
    {
        return $this->statusService->setStatus($key, $value);
    }
}
