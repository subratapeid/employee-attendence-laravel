<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin User
        $superAdmin = User::firstOrCreate([
            'email' => 'superadmin@example.com'
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('password123'),
        ]);
        // $superAdmin->assignRole('super-admin');

        // Create Admin User
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Admin User',
            'password' => bcrypt('password123'),
        ]);
        // $admin->assignRole('admin');

        // Create Normal User
        $user = User::firstOrCreate([
            'email' => 'user@example.com'
        ], [
            'name' => 'Normal User',
            'password' => bcrypt('password123'),
        ]);
        // $user->assignRole('user');

        echo "Users created successfully.\n";
    }
}
