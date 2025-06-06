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
        $initialSetting = [
            'app_name' => config('app.name', 'Internara'),
            'logo_path' => config('app.logo', 'images/logo.png'),
        ];

        Setting::truncate();
        Setting::create($initialSetting);
    }
}
