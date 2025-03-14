<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class School extends Model
{
    protected $fillable = [
        'address',
        'email',
        'fax',
        'logo',
        'name',
        'phone',
        'principal_name',
        'website',
    ];

    protected $casts = [
        'address' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($school) {
            $school->logo = $school->logo ?? asset('images/logo.png');
        });
    }

    /**
     * Get all of the departments for the School
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get all of the Classrooms for the School
     */
    public function Classrooms(): HasManyThrough
    {
        return $this->hasManyThrough(Classroom::class, Department::class);
    }
}
