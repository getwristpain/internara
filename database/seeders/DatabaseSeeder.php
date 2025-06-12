<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->runDatabaseSeeder();
        $this->runDatabaseTestSeeder();
    }

    protected function runDatabaseSeeder()
    {
        $this->call([
            SettingSeeder::class
        ]);
    }

    protected function runDatabaseTestSeeder(): void
    {
        if (app()->environment(['local', 'test', 'testing', 'dev', 'development'])) {
            $this->call(DBTestSeeder::class);
        }
    }
}
