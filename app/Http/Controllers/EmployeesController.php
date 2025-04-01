<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DutyStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class EmployeesController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view-attendance', only: ['index']),
            new Middleware('permission:edit-user', only: ['update']),
            new Middleware('permission:create-user', only: ['store']),
            new Middleware('permission:delete-user', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $searchKeyword = '%' . $request->search . '%';
            $query->where('name', 'like', $searchKeyword)
                ->orWhere('id', 'like', $searchKeyword)
                ->orWhere('email', 'like', $searchKeyword);
        }

        // Filter by account status (active or inactive)
        if ($request->filled('account_status')) {
            $query->where('account_status', $request->account_status);
        }

        // Filter by department or designation (based on the given filter)
        if ($request->filled('filter') && $request->filled('filter_value')) {
            $query->where($request->filter, $request->filter_value);
        }

        // Eager load duty status (latest for today) with select for specific columns
        $employees = $query->role('Employee') // Filter users by 'Employee' role
            ->with([
                'dutyStatus' => function ($query) {
                    $query->whereDate('created_at', Carbon::today()) // Filter for today's duty status
                        ->latest() // Get the latest entry
                        ->limit(1) // Limit to the most recent status
                        ->select('id', 'user_id', 'start_location', 'end_location', 'end_time', 'created_at', 'start_latitude', 'start_longitude', 'end_latitude', 'end_longitude');
                }
            ])
            ->paginate(15); // Paginate the result

        // Initialize starting sl_no (assuming pagination starts from 1)
        $sl_no = ($employees->currentPage() - 1) * $employees->perPage() + 1;

        // Process duty status and other information
        $employees->getCollection()->transform(function ($employee) use (&$sl_no) {
            $dutyStatus = $employee->dutyStatus->first();

            // Determine login and logout locations
            list($loginLocation, $logoutLocation) = $this->determineInOutLocations($employee, $dutyStatus);
            $employee->login_from = $loginLocation;
            $employee->logout_from = $logoutLocation;

            // Determine duty status and duty hours (handle cases where dutyStatus is null)
            $employee->duty_status = $dutyStatus ? $this->determineDutyStatus($dutyStatus) : 'Absent';
            $employee->duty_hours = $dutyStatus ? $this->calculateDutyHours($dutyStatus) : '-';

            // Determine start time
            $employee->start_time = $dutyStatus ? $dutyStatus->created_at->format('h:i A') : "-";

            // Select only desired data for frontend
            $data = [
                'id' => $employee->id,
                'sl_no' => $sl_no++,
                'name' => $employee->name,
                'email' => $employee->email,
                'emp_id' => $employee->emp_id,
                'phone' => $employee->phone ?? "-",
                'state' => $employee->state ?? "-",
                'branch' => $employee->branch ?? "-",
                'account_status' => $employee->account_status ?? "-",
                'start_location' => $dutyStatus->start_location ?? "-",
                'end_location' => $dutyStatus->end_location ?? "-",
                'login_from' => $employee->login_from ?? "-",
                'logout_from' => $employee->logout_from ?? "-",
                'duty_status' => $employee->duty_status ?? "-",
                'duty_hours' => $employee->duty_hours ?? "-",
                'start_time' => $employee->start_time ?? "-",
                'end_time' => $dutyStatus && $dutyStatus->end_time ? $dutyStatus->end_time->format('h:i A') : "-",
            ];

            return $data;
        });

        // return response()->json($employees);
        return view('pages.employees', compact('employees'));

    }

    private function determineInOutLocations($employee, $dutyStatus)
    {
        $loginLocation = '-';
        $logoutLocation = '-';

        if ($dutyStatus && $dutyStatus->start_latitude && $dutyStatus->start_longitude) {
            $loginDistance = $this->calculateDistance($employee, $dutyStatus, 'start');

            if ($loginDistance <= 1) {
                $loginLocation = 'Office Area';
            } else {
                $loginLocation = 'Outside Office';
            }

            if ($dutyStatus->end_latitude && $dutyStatus->end_longitude) {
                $logoutDistance = $this->calculateDistance($employee, $dutyStatus, 'end');

                if ($logoutDistance <= 1) {
                    $logoutLocation = 'Office Area';
                } else {
                    $logoutLocation = 'Outside Office';
                }
            }
        }

        return [$loginLocation, $logoutLocation];
    }

    private function calculateDistance($employee, $dutyStatus, $type = 'start')
    {
        if (!$employee || !$employee->latitude || !$employee->longitude) {
            return null;
        }

        $earthRadius = 6371; // Radius of the Earth in kilometers
        $lat1 = $type === 'start' ? $dutyStatus->start_latitude : $dutyStatus->end_latitude;
        $lon1 = $type === 'start' ? $dutyStatus->start_longitude : $dutyStatus->end_longitude;
        $lat2 = $employee->latitude;
        $lon2 = $employee->longitude;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }

    private function determineDutyStatus($dutyStatus)
    {
        if ($dutyStatus) {
            if ($dutyStatus->end_time === null) {
                return 'On Duty';
            } else {
                return 'Off Duty';
            }
        } else {
            return 'Absent';
        }
    }

    private function calculateDutyHours($dutyStatus)
    {
        if ($dutyStatus && $dutyStatus->end_time) {
            $diff = Carbon::parse($dutyStatus->end_time)->diff(Carbon::parse($dutyStatus->created_at));
        } elseif ($dutyStatus && !$dutyStatus->end_time) {
            $diff = Carbon::now()->diff(Carbon::parse($dutyStatus->created_at));
        } else {
            return 'N/A';
        }

        $hours = str_pad($diff->h, 2, '0', STR_PAD_LEFT);
        $minutes = str_pad($diff->i, 2, '0', STR_PAD_LEFT);

        return "$hours hrs $minutes min";
    }

    public function show($id)
    {
        $employee = User::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
        // Set default photo if null or empty
        $employee->photo = $employee->photo ?? asset('assets/img/user.png');
        return response()->json($employee);
    }


    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'emp_id' => 'required|string',
            'phone' => 'required|string|max:15',
            'state' => 'required|string',
            'district' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'location' => 'nullable|string',
            'role' => 'required|string|exists:roles,name',
        ]);

        // Add default password
        $validatedData['password'] = bcrypt('12345'); // Set your default password
        $validatedData['status'] = 'Active';
        $user = User::create($validatedData);
        // Assign the role using Spatie
        $user->assignRole($request->role);
        return response()->json(['success' => 'User Created successfully.']);
    }


    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $employee->update($validatedData);

        return response()->json(['success' => 'Employee updated successfully.']);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json(['success' => 'Employee deleted successfully.']);
    }


    public function resetPassword($id)
    {
        $employee = User::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        // Set a default new password (e.g., "password123") or generate a random one
        $newPassword = '12345';

        // Update the employee's password
        $employee->password = Hash::make($newPassword);
        $employee->save();

        return response()->json(['success' => 'Password has been reset successfully.', 'new_password' => $newPassword]);
    }
    public function export(Request $request)
    {
        $filter = $request->input('filter');
        $search = $request->input('search');

        return Excel::download(new EmployeesExport($filter, $search), 'employees.csv');
    }
}
