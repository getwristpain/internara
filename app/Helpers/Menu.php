<?php

namespace App\Helpers;

class Menu
{
    public static function all(): array
    {
        return config('menu');
    }
}
