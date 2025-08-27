<?php

namespace App\Helpers;

use App\Helpers\Helper;

class Menu extends Helper
{
    public static function all(): array
    {
        return config('menu');
    }
}
