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
            new Middleware('permission:view-user', only: ['show']),
            new Middleware('permission:create-user', only: ['create']),
            new Middleware('permission:delete-user', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get query parameters from the frontend
        $search = $request->input('search');
        $roleFilter = $request->input('role');
        $perPage = $request->input('per_page', 5); // Default to 5 per page

        // Query users with filters
        $query = User::select('id', 'name', 'email', 'status', 'created_at')
            ->with([
                'roles:id,name' // Select only required fields from roles
            ]);

        // Apply search filter on name or email
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Apply role filter if provided
        if (!empty($roleFilter)) {
            $query->whereHas('roles', function ($q) use ($roleFilter) {
                $q->where('name', $roleFilter);
            });
        }

        // Paginate with user-defined per page value
        $users = $query->latest()->paginate($perPage);

        // Calculate serial number and format the roles
        $users->getCollection()->transform(function ($user, $index) use ($users) {
            $user->roles = $user->roles->isEmpty() ? 'Guest' : $user->roles->pluck('name')->implode(', ') ?? 'Guest';

            // Calculate SL No based on current page and per page count
            $user->sl_no = ($users->currentPage() - 1) * $users->perPage() + ($index + 1);

            return $user->only(['sl_no', 'id', 'name', 'email', 'emp_id', 'status', 'created_at', 'roles']);
        });

        return response()->json($users);
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
