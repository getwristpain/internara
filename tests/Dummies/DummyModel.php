<?php

namespace Tests\Dummies;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DummyModel extends Model
{
    protected $fillable = [
        'name',
        'type',
        'message',
    ];

    public static function all($columns = ['*']): Collection
    {
        return new Collection([
            new static([
                'name' => 'Testing',
                'type' => 'test',
                'message' => 'testing is everything',
            ])
        ]);
    }

    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? parent::getAttribute($key);
    }
}
