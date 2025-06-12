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
                'type' => 'Application',
                'value' => config('app.name', 'Internara'),
                'value_type' => 'string',
                'description' => 'Nama aplikasi yang ditampilkan.',
                'label' => 'Nama aplikasi',
            ],
            [
                'key' => 'app_logo',
                'type' => 'Application',
                'value' => config('app.logo', 'images/logo.png'),
                'value_type' => 'string',
                'description' => 'Path atau URL logo aplikasi.',
                'label' => 'Logo aplikasi',
            ],
            [
                'key' => 'is_install',
                'type' => 'Application',
                'value' => false,
                'value_type' => 'boolean',
                'description' => 'Menandakan apakah aplikasi sudah diinstal.',
                'label' => 'Sudah diinstal',
            ]
        ];

        Setting::truncate();
        Setting::insert($settings);
    }
}
