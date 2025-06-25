<?php

namespace App\Models;

use App\Helpers\Generator;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id',
        'name',
        'description',
        'slug',
        'semester',
        'year',
        'start_date',
        'end_date',
        'notes',
    ];

    protected $initialStatuses = [
        'placement' => [
            [
                'name' => 'active',
                'label' => 'Aktif',
                'description' => 'Program sedang berjalan dan dapat menerima penempatan.',
                'priority' => 1,
                'color' => 'green',
                'is_default' => true,
            ],
            [
                'name' => 'inactive',
                'label' => 'Tidak aktif',
                'description' => 'Program sedang tidak aktif dan tidak menerima penempatan baru.',
                'priority' => 2,
                'color' => 'red',
                'is_default' => false,
            ],
            [
                'name' => 'archieved',
                'label' => 'Diarsipkan',
                'description' => 'Program telah selesai dan diarsipkan untuk referensi.',
                'priority' => 3,
                'color' => 'gray',
                'is_default' => false,
            ]
        ]
    ];

    public function setSlugAttribute(string $value): void
    {
        $value = empty($value) ? $this->name : $value;
        $slug = Str::slug($value) . '-' . Generator::key(8);

        $this->attributes['slug'] = empty($this->attributes['slug']) ? $slug : $this->attributes['slug'];
    }
}
