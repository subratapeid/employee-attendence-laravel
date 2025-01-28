<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define permissions
        $permissions = [
            'create-attendance',
            'view-attendance',
            'edit-attendance',
            'view-report',
            'download-report',
            'create-user',
            'view-user',
            'edit-user',
            'delete-user',
            'create-leave',
            'view-leave',
            'edit-leave',
            'delete-leave',
            'create-holiday',
            'view-holiday',
            'edit-holiday',
            'delete-holiday',
            'create-role',
            'view-role',
            'edit-role',
            'delete-role',
            'view-activity',
            'edit-activity',
            'delete-activity',
            'reset-password',
        ];

        // Insert permissions into the database
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Insert fixed roles into the database
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'User', 'guard_name' => 'web']);
        $employeeRole = Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);

        // Assign all permissions to Super Admin
        $superAdminRole->syncPermissions(Permission::all());

        // Assign specific permissions to Admin
        $adminRole->syncPermissions([
            'view-attendance',
            'edit-attendance',
            'download-report',
            'view-report',
            'create-user',
            'view-user',
            'create-leave',
            'view-leave',
            'edit-leave',
            'delete-leave',
        ]);

        // Assign limited permissions to User
        $userRole->syncPermissions([
            'create-attendance',
            'view-attendance',
            'create-leave',
            'view-leave',
        ]);

        // Assign limited permissions to Employee
        $employeeRole->syncPermissions([
            'create-attendance',
            'view-attendance',
            'create-leave',
            'view-leave',
        ]);

        echo "Roles and permissions seeded successfully.\n";
    }
}
