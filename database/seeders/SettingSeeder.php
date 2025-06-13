<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertInitialSettings();
    }

    protected function insertInitialSettings(): void
    {
        $settings = [
            [
                'key' => 'app_name',
                'value' => config('app.name', 'Internara'),
                'type' => 'string',
                'label' => 'Nama aplikasi',
                'category' => 'Application',
                'description' => 'Nama aplikasi yang ditampilkan.',
            ],
            [
                'key' => 'app_logo',
                'value' => config('app.logo', 'images/logo.png'),
                'type' => 'string',
                'label' => 'Logo aplikasi',
                'category' => 'Application',
                'description' => 'Path atau URL logo aplikasi.',
            ],
            [
                'key' => 'is_installed',
                'value' => false,
                'type' => 'boolean',
                'label' => 'Sudah diinstal',
                'category' => 'Application',
                'description' => 'Menandakan apakah aplikasi sudah diinstal.',
            ]
        ];

        Setting::truncate();
        Setting::insert($settings);
    }
}
