<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'fax',
        'email',
        'website',
        'logo',
        'principal_name',
    ];

    protected $casts = [
        'address' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($school) {
            $school->logo = $school->logo ?? asset('images/logo.png');
        });
    }
}
