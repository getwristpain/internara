<?php

namespace App\Models;

use App\Observers\SchoolObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

#[ObservedBy([SchoolObserver::class])]
class School extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'address',
        'email',
        'phone',
        'fax',
        'website',
        'principal_name',
    ];

    protected $casts = [
        'address' => 'array',
    ];

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
