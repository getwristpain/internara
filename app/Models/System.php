<?php

namespace App\Models;

use App\HasStatus;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasStatus;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'version',
        'logo',
        'is_installed',
    ];

    public array $initialStatuses = [
        'installation' => [
            [
                'name' => 'welcome',
                'label' => 'Selamat Datang',
                'description' => 'Halaman pembuka instalasi.',
                'priority' => 1,
            ],
            [
                'name' => 'school_config',
                'label' => 'Konfigurasi Sekolah',
                'description' => 'Masukkan nama, alamat, dsb.',
                'priority' => 2,
            ],
            [
                'name' => 'department_setup',
                'label' => 'Pengaturan Jurusan',
                'description' => 'Pengaturan jurusan yang akan diikuti PKL.',
                'priority' => 3,
            ],
            [
                'name' => 'owner_setup',
                'label' => 'Buat Akun Owner',
                'description' => 'Membuat akun owner pertama kali.',
                'priority' => 4,
            ],
            [
                'name' => 'complete',
                'label' => 'Instalasi Selesai',
                'description' => 'Semua tahap telah selesai.',
                'priority' => 5,
            ],
        ],
    ];

    /**
     * Boot the model.
     *
     * This method is called when the model is initialized.
     * It registers the creating event listener to set default values for name and logo.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($system) {
            $system->name ??= config('app.name');
            $system->version ??= config('app.version', '1.0.0');
            $system->logo ??= config('app.logo', 'images/logo.png');
        });

        static::updating(function ($system) {
            $system->name ??= config('app.name');
            $system->version ??= config('app.version', '1.0.0');
            $system->logo ??= config('app.logo', 'images/logo.png');
        });
    }
}
