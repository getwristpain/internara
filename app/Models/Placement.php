<?php

namespace App\Models;

use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Model;

class Placement extends Model
{
    use HasStatus;

    protected $fillable = [
        'program_id',
        'department_id',
        'company_id',
        'student_id',
        'teacher_id',
        'supervisor_id',
        'start_date',
        'end_date',
        'notes',
    ];

    protected array $initialStatuses = [
        'placement' => [
            [
                'name' => 'pending',
                'label' => 'Tertunda',
                'priority' => 1,
                'color' => 'yellow',
                'is_default' => 'true',
            ],
            [
                'name' => 'approved',
                'label' => 'Disetujui',
                'priority' => 2,
                'color' => 'green',
                'is_default' => 'false',
            ],
            [
                'name' => 'rejected',
                'label' => 'Ditolak',
                'priority' => 3,
                'color' => 'red',
                'is_default' => 'false',
            ],
            [
                'name' => 'in_progress',
                'label' => 'Sedang Berlangsung',
                'priority' => 4,
                'color' => 'blue',
                'is_default' => 'false',
            ],
            [
                'name' => 'completed',
                'label' => 'Selesai',
                'priority' => 5,
                'color' => 'green',
                'is_default' => 'false',
            ],
            [
                'name' => 'stopped',
                'label' => 'Dihentikan',
                'priority' => 6,
                'color' => 'orange',
                'is_default' => 'false',
            ],
            [
                'name' => 'archived',
                'label' => 'Diarsipkan',
                'priority' => 7,
                'color' => 'gray',
                'is_default' => 'false',
            ],
        ]
    ];
}
