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
        // Call the RoleSeeder to insert fixed roles
        $this->call(RolePermissionSeeder::class);
        // Call the UserSeeder to insert fixed users
        $this->call(UserSeeder::class);
        // Call the CompanyLeavesSeeder to insert
        $this->call(CompanyLeavesSeeder::class);
    }
}
