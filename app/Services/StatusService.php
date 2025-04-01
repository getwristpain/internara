<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\Status;

class StatusService extends Service
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new Status);
    }

    public function getStatus(string $key, string $value = ''): ?Status
    {
        $conditions = ['key' => $key, 'value' => $value];
        $filteredCondition = Helper::filter($conditions);

        return $this->firstWhere($filteredCondition);
    }

    public function setStatus(string $key, string $value): bool
    {
        return $this->updateOrCreate(['key' => $key], ['value' => $value]) ? true : false;
    }
}
