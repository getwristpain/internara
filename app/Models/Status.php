<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'type',
        'label',
        'description',
        'priority',
        'flag',
        'is_default',
        'color',
        'icon',
    ];

    /**type
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
