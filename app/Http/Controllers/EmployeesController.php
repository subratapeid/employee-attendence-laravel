<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('id', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Filtering by department or designation
        if ($request->filled('filter') && $request->filled('filter_value')) {
            $query->where($request->filter, $request->filter_value);
        }

        // Paginate the results (15 per page)
        $employees = $query->paginate(15);

        // Calculate the serial number based on the current page
        $sl_no = ($employees->currentPage() - 1) * $employees->perPage() + 1;

        return view('pages.employees', compact('employees', 'sl_no'));
    }
    public function show($id)
    {
        $employee = User::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        return response()->json($employee);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ]);

        // Add default password
        $validatedData['password'] = bcrypt('abcd123'); // Set your default password

        User::create($validatedData);

        return response()->json(['success' => 'Employee added successfully.']);
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
        $newPassword = 'abcd@12345';

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
