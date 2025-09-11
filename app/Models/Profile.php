<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
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
        'postal_code',
        'phone',
        'emergency_name',
        'emergency_relation',
        'emergency_address',
        'emergency_phone',
    ];

    public static function getEmergencyRelationOptions(): array
    {
        return [
            'father' => 'Ayah Kandung',
            'mother' => 'Ibu Kandung',
            'sibling' => 'Saudara Kandung',
            'relative' => 'Kerabat',
            'guardian' => 'Wali',
            'other' => 'Lainnya',
        ];
    }
}
