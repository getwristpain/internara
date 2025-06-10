<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
