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
            'logo' => config('app.logo', 'images/logo.png'),
            'installed' => false,
        ];

        System::truncate();
        System::create($data);
    }
}
