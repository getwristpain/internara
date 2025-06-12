<?php

namespace App\Models;

use App\Models\Program;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Placement extends Model
{
    use HasStatus;

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
                'name' => 'active',
                'label' => 'Aktif',
                'priority' => 2,
                'color' => 'yellow',
                'is_default' => 'false',
            ],
            [
                'name' => 'rejected',
                'label' => 'Ditolak',
                'priority' => 3,
                'color' => 'red',
                'is_default' => 'false',
            ]
        ]
    ];

    protected $fillable = [
        'program_id',
        'company_id',
        'student_id',
        'teacher_id',
        'supervisor_id',
        'start_date',
        'end_date',
        'notes',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class);
    }
}
