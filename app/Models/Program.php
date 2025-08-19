<?php

namespace App\Models;

use App\Helpers\Transform;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'year',
        'semester',
        'date_start',
        'date_end',
        'status',
        'description',
    ];
}
