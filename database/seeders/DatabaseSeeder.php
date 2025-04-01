<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            SystemSeeder::class,
            RoleSeeder::class,
        ]);
    }

    protected function runDatabaseTestSeeder(): void
    {

        $devEnv = in_array(app()->environment(), ['testing', 'local', 'development', 'dev'], true);
        if ($devEnv) {
            $this->call(DBTestSeeder::class);
        }
    }
}
