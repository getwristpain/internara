<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->runProdSeeders();
        $this->runDevSeeders();
    }

    protected function runProdSeeders()
    {
        $this->call([
            SettingSeeder::class,
            StatusesSeeder::class,
            RolesAndPermissionsSeeder::class,
            OwnerSeeder::class,
        ]);
    }

    protected function runDevSeeders()
    {
        if (setting()->isDev()) {
            $this->call([
                SchoolSeeder::class,
                DepartmentSeeder::class,
                ProgramSeeder::class,
            ]);
        }
    }
}
