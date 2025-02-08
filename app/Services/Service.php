<?php

namespace App\Services;

use App\Debugger;
use Illuminate\Database\Eloquent\Model;

class Service
{
    use Debugger;

    protected Model $model;

    /*
     * Class constructor.
     */
    protected function __construct(Model $model)
    {
        $this->model = $model;
    }
}
