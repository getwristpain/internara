<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;

class StatusService extends Service
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(new Status());
    }

    public function get(string $key = '', string $type = ''): Status|Collection|null
    {
        $conditions = Helper::filter(['key' => $key, 'type' => $type]);

        if (empty($conditions['key'])) {
            return $this->model()->query()->where($conditions)->get();
        }

        return $this->model()->query()->where($conditions)->first();
    }

    public function getValue(string $key, string $type = ''): string
    {
        return $this->get($key, $type)?->value ?? '';
    }

    public function mark(string $key, string $type = '', string $column = 'flag', bool $strict = false): bool
    {
        $status = $this->get($key, $type);

        if (!$status) {
            return false;
        }

        $status->$column = !$strict ? !$status->$column : true;
        $status->save();

        return true;
    }

    public function isMarked(string $key, string $type = '', string $column = 'flag'): bool
    {
        $status = $this->get($key, $type);

        if (!$status) {
            return false;
        }

        return (bool) $status->$column;
    }
}
