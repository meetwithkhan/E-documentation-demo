<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        $manager = User::create([
            'name'     => 'Manager',
            'email'    => 'manager@example.com',
            'password' => bcrypt('password'),
        ]);
        $manager->assignRole('manager');
    }
}