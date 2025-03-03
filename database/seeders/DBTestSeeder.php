<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DBTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
        ]);
    }
}
