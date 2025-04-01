<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'guest', 'owner', 'admin', 'staff', 'student', 'teacher', 'supervisor',
        ];

        foreach ($data as $role) {
            Role::create(['name' => $role]);
        }
    }
}
