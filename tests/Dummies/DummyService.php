<?php

namespace Tests\Dummies;

use App\Services\Service;

class DummyService extends Service
{
    public function __construct()
    {
        parent::__construct(new DummyModel());
    }
}
