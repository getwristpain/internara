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
        'logo_path',
        'principal_name',
    ];

    protected $casts = [
        'address' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($school) {
            $school->logo_path = $school->logo_path ?? asset('images/logo.png');
        });
    }
}
