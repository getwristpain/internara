<?php

namespace App\Services;

use App\Models\System;
use App\Services\Service;

class SystemService extends Service
{
    /*
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(new System());
    }

    public static function isInstalled(): bool
    {
        return self::$model?->installed ?? false;
    }
}
