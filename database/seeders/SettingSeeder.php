<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $initialSettings = [
            [
                'key' => 'brand_name',
                'value' => config('app.name'),
                'label' => 'Nama Brand',
            ],
            [
                'key' => 'brand_logo',
                'value' => config('app.logo'),
                'label' => 'Logo Brand',
            ],
            [
                'key' => 'is_installed',
                'value' => false,
                'label' => 'Aplikasi Terinstal',
            ],
        ];

        Setting::upsert($initialSettings, ['key'], ['value', 'label']);
    }
}
