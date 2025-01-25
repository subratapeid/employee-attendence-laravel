<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view-role', only: ['index']),
            new Middleware('permission:edit-role', only: ['edit']),
            new Middleware('permission:create-role', only: ['create']),
            new Middleware('permission:delete-role', only: ['destroy']),
        ];
    }
    //this method will show all Roles
    public function index()
    {
        $roles = Role::orderBy('created_at', 'DESC')->paginate(10);
        return view('roles.list', [
            'roles' => $roles
        ]);

    }
    // this method will show create role page
    public function create()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->get();
        return view('roles.create', [
            'permissions' => $permissions
        ]);
    }

    // This method will create role in db
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3'
        ]);

        if ($validator->passes()) {
            $role = Role::create(['name' => $request->name]);
            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }
            return redirect()->route('roles.index')->with('success', 'role Created Successfully');
        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

    // This method will show edit role page 
    public function edit()
    {

    }

    // This method will Updae role 
    public function update()
    {

    }
    // This method will Delete role From db
    public function destroy()
    {

    }
}
