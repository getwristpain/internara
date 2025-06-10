<?php

namespace App\Helpers;

use App\Helpers\Helper;
use Illuminate\Support\Str;

class Generator extends Helper
{
    public static function key(string $identifier = '', bool $timestamp = false): string
    {
        $identifier = empty($identifier) ? md5(uniqid()) : Str::slug($identifier);
        $datetime = now()->format('Ymd-Hi');
        $key = implode('-', Helper::filter([$datetime, $identifier, Str::random(8)]));

        return $timestamp ? implode('-', [$datetime, md5($key)]) : md5($key);
    }
}
