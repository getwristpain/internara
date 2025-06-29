<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'department_id',
        'school_id',
        'classroom',
        'id_number',
        'phone',
        'address',
        'emergency_name',
        'emergency_relation',
        'emergency_phone',
        'emergency_address'
    ];

    public function placements(): HasMany
    {
        return $this->hasMany(Placement::class);
    }
}
