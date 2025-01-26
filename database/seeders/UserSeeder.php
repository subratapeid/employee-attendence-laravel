<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $employeeRole = Role::where('name', 'Employee')->first();

        User::create([
            'name' => 'Admin User',
            'email' => 'subratap.eid@gmail.com',
            'password' => bcrypt('123456'),
        ])->assignRole($adminRole);

        // Create super admin user
        User::create([
            'name' => 'Super Admin',
            'email' => 'subratap@integramicro.co.in',
            'password' => bcrypt('123456'),
            'latitude' => '13.08379650',
            'longitude' => '77.58638670',

        ])->assignRole($superAdminRole);

        // Create Employee user1
        User::create([
            'name' => 'Employee-1',
            'email' => 'employee1@integramicro.co.in',
            'password' => bcrypt('12345'),
            'latitude' => '13.08379650',
            'longitude' => '77.58638670',

        ])->assignRole($employeeRole);
        // Create Employee user2
        User::create([
            'name' => 'Employee-2',
            'email' => 'employee2@integramicro.co.in',
            'password' => bcrypt('12345'),
            'latitude' => '13.08379650',
            'longitude' => '77.58638670',

        ])->assignRole($employeeRole);

    }
}
