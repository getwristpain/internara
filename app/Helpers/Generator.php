<?php

namespace App\Helpers;

use App\Helpers\Helper;
use Illuminate\Support\Str;

class Generator extends Helper
{
    public static function key(string $identifier, bool $timestamp = false)
    {
        $identiifer = empty($identifier) ? md5(uniqid()) : $identifier;
        $time = now()->toDateTimeString();

        $key = implode('-', Helper::filter([$time, $identifier, Str::random(8)]));
        return $timestamp ? implode('-', [$time, md5($key)]) : md5($key);
    }
}
