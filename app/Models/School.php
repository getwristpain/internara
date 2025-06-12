<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    protected $fillable = [
        'name',
        'logo_path',
        'address',
        'email',
        'phone',
        'fax',
        'website',
        'principal_name',
    ];

    /**
     * Get all of the departments for the School
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }
}
