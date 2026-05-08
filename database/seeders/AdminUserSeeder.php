<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'employee_id' => User::generateEmployeeId(),
                'name'        => 'Admin',
                'password'    => bcrypt('password'),
            ]
        );
        $admin->syncRoles(['admin']);

        $manager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'employee_id' => User::generateEmployeeId(),
                'name'        => 'Manager',
                'password'    => bcrypt('password'),
            ]
        );
        $manager->syncRoles(['manager']);
    }
}