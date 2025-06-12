<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'slug',
        'semester',
        'year',
        'start_date',
        'end_date',
        'notes',
        ''
    ];

    protected $statuses = [
        'placement' => [
            [
                'name' => 'active',
                'label' => 'Aktif',
                'description' => 'Program sedang berjalan dan dapat menerima penempatan.',
                'priority' => 1,
                'is_default' => false,
            ],
            [
                'name' => 'inactive',
                'label' => 'Tidak aktif',
                'description' => 'Program sedang tidak aktif dan tidak menerima penempatan baru.',
                'priority' => 2,
                'is_default' => true,
            ],
            [
                'name' => 'archieved',
                'label' => 'Diarsipkan',
                'description' => 'Program telah selesai dan diarsipkan untuk referensi.',
                'priority' => 3,
                'is_default' => false,
            ]
        ]
    ];
}
