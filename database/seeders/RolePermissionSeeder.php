<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Define permissions for each module
        $modules = ['attendance', 'report', 'user', 'leave'];
        $actions = ['create', 'view', 'edit', 'delete'];

        // Create permissions like create-attendance, view-attendance, etc.
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::create(['name' => "{$action}-{$module}"]);
            }
        }

        // Create roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Assign permissions to the user role (as per your request)
        $userPermissions = [
            'create-attendance',
            'view-attendance',
            'create-leave',
            'view-leave'
        ];
        $userRole->givePermissionTo($userPermissions);

        // Assign all permissions to super-admin
        $allPermissions = Permission::all();
        $superAdminRole->givePermissionTo($allPermissions);

        // Assign all except 'user' related permissions to admin
        $adminPermissions = $allPermissions->filter(function ($permission) {
            return !str_contains($permission->name, 'user');
        });
        $adminRole->givePermissionTo($adminPermissions);

        echo "Roles and permissions created successfully.";
    }
}


// $user = \App\Models\User::find(1);
// $user->assignRole('super-admin'); // Assign super-admin role

// $anotherUser = \App\Models\User::find(2);
// $anotherUser->assignRole('user'); // Assign user role
