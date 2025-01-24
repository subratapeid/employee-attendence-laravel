<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
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
    // This method will Updae permission 

    public function update()
    {

    }
    // This method will Delete permission From db
    public function destroy()
    {

    }
}
