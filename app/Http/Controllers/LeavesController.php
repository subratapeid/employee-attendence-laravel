<?php

namespace App\Http\Controllers;

use App\Models\CompanyLeave;
use App\Models\DutyStatus;
use Illuminate\Http\Request;

class LeavesController extends Controller
{
    // // Get all relevant data for the calendar (Company Leaves, Employee Leaves, and Attended Dates)
    // public function getCalendarData()
    // {
    //     // Fetch all company leaves (leave_date and reason)
    //     $companyLeaves = CompanyLeave::select('leave_date', 'reason')->get();

    //     // Get the unique dates from created_at field of duty_statuses (attended dates)
    //     $attendedDates = DutyStatus::selectRaw('DATE(created_at) as date') // Get the date part of created_at
    //         ->groupBy('date')
    //         ->get()
    //         ->pluck('date'); // Extract the date column as an array

    //     // Fetch employee leaves (leave_date and leave_type)
    //     $employeeLeaves = CompanyLeave::select(['leave_date', 'reason'])->get(); // Assuming leave_date and leave_type are columns

    //     // Return all the data in a single JSON response
    //     return response()->json([
    //         'company_leaves' => $companyLeaves,
    //         'employee_leaves' => $employeeLeaves,
    //         'attended_dates' => $attendedDates
    //     ]);
    // }



    // use Illuminate\Support\Carbon;

    public function getCalendarData(Request $request)
    {
        // Get the current year and month if not provided
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        // Fetch company leaves for the given month and year
        $companyLeaves = CompanyLeave::whereYear('leave_date', $year)
            ->whereMonth('leave_date', $month)
            ->select('leave_date', 'reason')
            ->get();

        // Fetch employee leaves for the given month and year
        $employeeLeaves = CompanyLeave::whereYear('leave_date', $year)
            ->whereMonth('leave_date', $month)
            ->select('leave_date', 'reason')
            ->get();

        // Fetch attended dates for the given month and year
        $attendedDates = DutyStatus::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->pluck('date');

        return response()->json([
            'year' => $year,
            'month' => $month,
            'company_leaves' => $companyLeaves,
            'employee_leaves' => $employeeLeaves,
            'attended_dates' => $attendedDates
        ]);
    }


}
