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
    // This method will Show edit permission page

    public function edit()
    {

    }
    // This method will Updae permission 

    public function update()
    {

    }
    // This method will Delete permission From db
    public function destroy()
    {

    }
}
