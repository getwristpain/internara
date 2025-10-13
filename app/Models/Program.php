<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'year',
        'semester',
        'date_start',
        'date_finish',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'date_start' => 'datetime',
            'date_finish' => 'datetime',
        ];
    }
}
