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
            SettingSeeder::class
        ]);
    }

    protected function runDevSeeders()
    {
        if (app()->isLocal()) {
            $this->call([
                //
            ]);
        }
    }
}
