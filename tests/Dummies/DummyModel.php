<?php

namespace Tests\Dummies;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DummyModel extends Model
{
    protected $fillable = [
        'name',
        'type',
        'message'
    ];

    public static function all($columns = ['*']): Collection
    {
        return new Collection([[
            'name' => 'Testing',
            'type' => 'test',
            'message' => 'testing is everything'
        ]]);
    }

    public function getAttribute($key)
    {
        $attributes = [
            'name' => 'Testing',
            'type' => 'test',
            'message' => 'testing is everything'
        ];

        return $attributes[$key] ?? null;
    }
}
