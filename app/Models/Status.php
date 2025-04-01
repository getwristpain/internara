<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
        'description',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($status) {
            $status->key = Str::lower($status->key);
            $status->value = Str::lower($status->value);
        });

        static::updating(function ($status) {
            $status->key = Str::lower($status->key);
            $status->value = Str::lower($status->value);
        });
    }
}
