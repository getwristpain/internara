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
        $prodSettings = [
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

        $devSettings = [
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
                'value' => true,
                'label' => 'Aplikasi Terinstal',
            ],
        ];

        if (setting()->isDev() && !empty($devSettings)) {
            foreach ($devSettings as $set) {
                Setting::updateOrCreate(['key' => $set['key']], $set);
            }

            return;
        }

        if (!empty($prodSettings)) {
            foreach ($prodSettings as $set) {
                Setting::updateOrCreate(['key' => $set['key']], $set);
            }

            return;
        }
    }
}
