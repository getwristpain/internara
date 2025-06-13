<?php

namespace App\Models;

use App\Helpers\Sanitizer;
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
        'key',
        'value',
        'type',
        'label',
        'category',
        'description',
    ];

    protected $statuses = [
        'installation' => [
            [
                'key' => 'welcome',
                'label' => 'Selamat datang',
                'description' => 'Langkah awal instalasi aplikasi. Menampilkan pesan sambutan kepada pengguna.',
            ],
            [
                'key' => 'school_config',
                'label' => 'Konfigurasi sekolah',
                'description' => 'Pengaturan data dan informasi sekolah yang diperlukan sebelum melanjutkan proses instalasi.',
            ],
            [
                'key' => 'department_setup',
                'label' => 'Pengaturan jurusan',
                'description' => 'Menambahkan dan mengatur jurusan atau program studi yang tersedia di sekolah.',
            ],
            [
                'key' => 'owner_setup',
                'label' => 'Pengaturan pemilik',
                'description' => 'Menentukan atau mengatur pemilik atau administrator utama aplikasi.',
            ],
            [
                'key' => 'complete',
                'label' => 'Selesai',
                'description' => 'Seluruh proses instalasi telah selesai dan aplikasi siap digunakan.',
            ]
        ]
    ];

    public function getValueAttribute($value): mixed
    {
        return match ($this->type) {
            'boolean'      => Sanitizer::sanitize($value, 'bool'),
            'integer'      => Sanitizer::sanitize($value, 'int'),
            'float'        => Sanitizer::sanitize($value, 'float'),
            'array'        => Sanitizer::sanitize($value, 'array'),
            'array_bool'   => Sanitizer::sanitize($value, 'array_bool'),
            'array_float'  => Sanitizer::sanitize($value, 'array_float'),
            'array_int'    => Sanitizer::sanitize($value, 'array_int'),
            'array_string' => Sanitizer::sanitize($value, 'array_string'),
            'json'         => Sanitizer::sanitize($value, 'json'),
            'email'        => Sanitizer::sanitize($value, 'email'),
            'html'         => Sanitizer::sanitize($value, 'html'),
            'string'       => Sanitizer::sanitize($value, 'string'),
            'url'          => Sanitizer::sanitize($value, 'url'),
            'message'      => Sanitizer::sanitize($value, 'message'),
            default        => $value,
        };
    }

    public function setValueAttribute($value): void
    {
        $this->attributes['value'] = is_array($value) || is_object($value)
            ? json_encode($value)
            : (string) $value;
    }
}
