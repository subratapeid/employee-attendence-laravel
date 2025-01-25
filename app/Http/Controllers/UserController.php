<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view-user', only: ['index']),
            new Middleware('permission:edit-user', only: ['edit']),
            new Middleware('permission:create-user', only: ['create']),
            new Middleware('permission:delete-user', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve paginated users along with their roles using eager loading
        // $users = User::with('roles')->latest()->paginate(5);
        $users = User::latest()->paginate(5);

        // Add a 'roles' attribute to each user as a comma-separated list of roles
        // $users->getCollection()->transform(function ($user) {
        //     $user->roles = $user->roles->pluck('name')->implode(', '); // Concatenate role names as a string
        //     return $user;
        // });

        // Pass the users data to the view
        return view('users.list', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('users.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email'

        ]);
        if ($validator->passes()) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(123456)
            ]);

            $user->syncRoles($request->role);
            return redirect()->route('users.index')->with('success', 'User added successfully.');
        } else {
            return redirect()->route('users.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('name', 'ASC')->get();
        $hasRoles = $user->roles->pluck('id');
        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'hasRoles' => $hasRoles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users,email,' . $id . ',id'
        ]);
        if ($validator->passes()) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
            $user->syncRoles($request->role);
            return redirect()->route('users.index')->with('success', 'User Updated Successfully.');
        } else {
            return redirect()->route('users.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        if ($user == null) {
            session()->flash('error', 'user not Found');
            return response()->json([
                'status' => false,
                'error' => 'user not Found'
            ]);
        }
        $user->delete();
        session()->flash('success', 'Role Deleted Successfully.');
        return response()->json([
            'status' => true,
            'message' => 'Role Deleted Successfully'
        ]);
    }
}
