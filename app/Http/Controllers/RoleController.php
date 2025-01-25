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
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::OrderBy('name', 'ASC')->get();
        return view('roles.edit', [
            'hasPermissions' => $hasPermissions,
            'permissions' => $permissions,
            'role' => $role
        ]);

    }

    // This method will Updae role 
    public function update($id, Request $request)
    {
        $role = Role::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:roles,name,' . $id . ',id'
        ]);
        if ($validator->passes()) {
            $role->name = $request->name;
            $role->save();
            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }
            return redirect()->route('roles.index')->with('success', 'Role Updated Successfully.');
        } else {
            return redirect()->route('roles.edit', $id)->withInput()->withError($validator);
        }
    }
    // this methode will Delete permission from DB
    public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Role::find($id);
        if ($role == null) {
            session()->flash('error', 'Role not Found');
            return response()->json([
                'status' => false,
                'error' => 'Role not Found'
            ]);
        }
        $role->delete();
        session()->flash('success', 'Role Deleted Successfully.');
        return response()->json([
            'status' => true,
            'message' => 'Role Deleted Successfully'
        ]);
    }
}
