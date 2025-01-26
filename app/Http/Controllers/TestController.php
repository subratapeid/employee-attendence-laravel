<?php
namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
class TestController extends Controller
{
    public function fetchEmployees(Request $request)
    {
        // Get filters from the request
        $search = $request->input('search');
        $department = $request->input('department');
        $status = $request->input('status');
        $perPage = $request->input('per_page', default: 1); // Default to 10 records per page

        // Build query with filters
        $query = User::query();

        if ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        if ($department) {
            $query->where('department', $department);
        }

        if ($status) {
            $query->where('status', $status);
        }

        // Paginate the filtered data with dynamic per-page count
        $employees = $query->paginate($perPage);

        // Return as JSON response
        return response()->json($employees);
    }

}