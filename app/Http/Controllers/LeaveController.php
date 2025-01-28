<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EmployeeLeave;

class LeaveController extends Controller
{
    // Method to get all leaves
    public function index(Request $request)
    {
        // Get the currently logged-in user
        $user = auth()->user();

        // Fetch the leaves data for the logged-in user
        $leaves = EmployeeLeave::where('user_id', $user->id)->get();

        // Format the leaves data with SL No, formatted dates, and calculated days
        $formattedLeaves = $leaves->map(function ($leave, $index) {
            // Calculate the number of leave days
            $fromDate = Carbon::parse($leave->from_date);
            $toDate = Carbon::parse($leave->to_date);
            $days = $fromDate->diffInDays($toDate) + 1; // Include both start and end dates

            return [
                'sl_no' => $index + 1, // Add SL No, starting from 1
                'from_date' => $fromDate->format('d-m-Y'), // Format from_date
                'to_date' => $toDate->format('d-m-Y'), // Format to_date
                'remarks' => $leave->remarks,
                'status' => $leave->status,
                'created_at' => Carbon::parse($leave->created_at)->format('d-m-Y'), // Format created_at
                'days' => $days, // Add the number of days of leave
            ];
        });

        // Return the data as JSON for AJAX response
        return response()->json([
            'success' => true,
            'data' => $formattedLeaves
        ]);
    }


    // Method to handle the leave application
    public function applyLeave(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'fromDate' => 'required|date|before_or_equal:toDate',
            'toDate' => 'required|date|after_or_equal:fromDate',
            'remarks' => 'required|string|max:255',
        ]);

        // Create leave entry in the database
        $leave = new EmployeeLeave();
        $leave->user_id = auth()->user()->id;  // Assuming user is logged in
        $leave->from_date = $validated['fromDate'];
        $leave->to_date = $validated['toDate'];
        $leave->remarks = $validated['remarks'];
        $leave->status = 'Pending';  // You can change the status as per your logic
        $leave->save();

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Leave application submitted successfully.',
        ]);
    }
}
