<?php

namespace App\Helpers;

class Arr extends Helper
{
    public static function filter(...$params): array
    {
        return array_filter(array_merge(...$params), fn ($param) => ! empty($param));
    }
}
