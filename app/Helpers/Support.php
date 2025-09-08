<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class Support
{
    /**
     * @param array $attributes
     * @param string<class-string> $model
     *
     * @return array
     */
    public static function filterFillable(array $attributes, string $model): array
    {
        return array_intersect_key($attributes, array_flip(app($model)->getFillable()));
    }
}
