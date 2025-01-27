<?php

namespace App\Http\Controllers;

use App\Models\CompanyLeave;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HolidayController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view-holiday', only: ['index']),
            new Middleware('permission:edit-holiday', only: ['edit']),
            new Middleware('permission:create-holiday', only: ['create']),
            new Middleware('permission:delete-holiday', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve paginated users along with their roles using eager loading
        // $users = User::with('roles')->latest()->paginate(5);
        $holidays = CompanyLeave::latest()->paginate(50);

        // Add a 'roles' attribute to each user as a comma-separated list of roles
        // $users->getCollection()->transform(function ($user) {
        //     $user->roles = $user->roles->pluck('name')->implode(', '); // Concatenate role names as a string
        //     return $user;
        // });

        // Pass the users data to the view
        return view('holiday.list', ['holidays' => $holidays]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('holiday.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'holiday_date' => 'required|date',
            'state' => 'required|string|max:255',
            'reason' => 'required|string|max:500',
        ], [
            'holiday_date.required' => 'Please select a holiday date.',
            'state.required' => 'Please select a state.',
            'reason.required' => 'Please enter reason.'
        ]);

        CompanyLeave::create([
            'leave_date' => $request->holiday_date,
            'state' => $request->state,
            'reason' => $request->reason,
            'status' => 'active',
        ]);

        return response()->json(['success' => true, 'message' => 'Holiday added successfully!']);
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
        $holiday = CompanyLeave::findOrFail($id);
        return view('holiday.edit', [
            'holiday' => $holiday
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
        $holiday = CompanyLeave::find($id);
        if ($holiday == null) {
            session()->flash('error', 'Holiday not Found');
            return response()->json([
                'status' => false,
                'error' => 'Holiday not Found'
            ]);
        }
        $holiday->delete();
        session()->flash('success', 'Holiday Deleted Successfully.');
        return response()->json([
            'status' => true,
            'message' => 'Holiday Deleted Successfully'
        ]);
    }

    public function getStates()
    {
        $states = [
            'All States',
            'Maharashtra',
            'Delhi',
            'Karnataka',
            'Tamil Nadu',
            'Uttar Pradesh',
            'Gujarat'
        ];

        return response()->json($states);
    }
}
