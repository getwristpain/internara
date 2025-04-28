<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => config('app.name', 'Internara'),
            'version' => config('app.version', '1.0.0'),
            'logo' => config('app.logo', 'images/logo.png'),
            'installed' => false,
        ];

        System::truncate();
        System::create($data);
    }
}
