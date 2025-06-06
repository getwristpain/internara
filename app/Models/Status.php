<?php

namespace App\Models;

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
        'label',
        'description',
        'priority',
        'color',
        'icon',
        'flag',
        'is_default',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'priority' => 'integer',
        'flag' => 'boolean',
        'is_default' => 'boolean',
    ];
}
