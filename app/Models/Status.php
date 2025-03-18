<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'description'
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
            $status->name = Str::lower($status->name);
            $status->type = Str::lower($status->type);
        });

        static::updating(function ($status) {
            $status->name = Str::lower($status->name);
            $status->type = Str::lower($status->type);
        });
    }
}
