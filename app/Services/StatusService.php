<?php

namespace App\Services;

use App\Models\Status;

class StatusService extends Service
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new Status());
    }

    public function mark(string $name, string $type = '', string $column = 'flag', bool $strict = false): bool
    {
        $status = $this->model()->query()->where(['name' => $name, 'type' => $type])->first();
        if (!$status) {
            return false;
        }

        $status->$column = !$strict ? !$status->$column : true;
        $status->save();

        return true;
    }
}
