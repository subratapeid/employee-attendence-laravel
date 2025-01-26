<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class PermissionController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view-permission', only: ['index']),
            new Middleware('permission:edit-permission', only: ['edit']),
            new Middleware('permission:create-permission', only: ['create']),
            new Middleware('permission:delete-permission', only: ['destroy']),
        ];
    }
    //this method will show all permission
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(10);
        return view('permissions.list', [
            'permissions' => $permissions
        ]);

    }
    // this method will show create permission page
    public function create()
    {
        return view('permissions.create');
    }

    // This method will create permission in db
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3'
        ]);

        if ($validator->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permission Created Successfully');
        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    // this methode will show edit permission page
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', [
            'permission' => $permission
        ]);

    }
    // this methode will update a permission
    public function update($id, Request $request)
    {
        $permission = Permission::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,' . $id . ',id'
        ]);
        if ($validator->passes()) {
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('success', 'Permission Updated Successfully.');
        } else {
            return redirect()->route('permissions.edit,$id')->withInput()->withError($validator);
        }
    }
    // this methode will Delete permission from DB
    public function destroy(Request $request)
    {
        $id = $request->id;
        $permission = Permission::find($id);
        if ($permission == null) {
            session()->flash('error', 'Permission not Found');
            return response()->json([
                'status' => false,
                'error' => 'Permission not Found'
            ]);
        }
        $permission->delete();
        session()->flash('success', 'Permission Deleted Successfully.');
        return response()->json([
            'status' => true,
            'message' => 'Permission Deleted Successfully'
        ]);
    }
}
