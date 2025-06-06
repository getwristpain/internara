<?php

namespace App\Models;

use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasStatus;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'app_name',
        'logo_path',
        'is_installed',
    ];

    protected $casts = [
        'is_installed' => 'boolean',
    ];

    public array $initialStatuses = [
        'installation' => [
            [
                'name' => 'welcome',
                'label' => 'Mulai Instalasi',
                'description' => 'Menyiapkan proses instalasi.',
                'priority' => 1,
            ],
            [
                'name' => 'school_config',
                'label' => 'Konfigurasi Sekolah',
                'description' => 'Mengonfigurasi sekolah.',
                'priority' => 2,
            ],
            [
                'name' => 'department_setup',
                'label' => 'Pengaturan Jurusan',
                'description' => 'Mengatur jurusan dan kelas.',
                'priority' => 3,
            ],
            [
                'name' => 'owner_setup',
                'label' => 'Buat Akun Owner',
                'description' => 'Membuat akun pemilik.',
                'priority' => 4,
            ],
            [
                'name' => 'complete',
                'label' => 'Instalasi Selesai',
                'description' => 'Menyelesaikan instalasi.',
                'priority' => 5,
            ],
        ],
    ];

    public function setAttribute($key, $value): void
    {
        match ($key) {
            'app_name' => $value ??= config('app.name'),
            'logo_path' => $value ??= config('app.logo', 'images/logo.png'),
            default => $value
        };

        parent::setAttribute($key, $value);
    }
}
