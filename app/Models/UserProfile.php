<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'identity',
        'position',
        'address',
        'phone',
        'emergency_name',
        'emergency_relation',
        'emergency_address',
        'emergency_phone',
    ];
}
