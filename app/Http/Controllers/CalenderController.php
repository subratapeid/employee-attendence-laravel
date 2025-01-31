<?php

namespace App\Http\Controllers;

use App\Models\CompanyLeave;
use App\Models\DutyStatus;
use App\Models\EmployeeLeave;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalenderController extends Controller
{
    public function getCalendarData(Request $request)
    {
        // Get the current year and month if not provided
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        // $appStartDate = Carbon::parse('2025-01-10');
        $appStartDate = Carbon::parse(env('APP_START_DATE', '2025-01-01'));


        // Fetch company leaves for the given month and year
        $companyLeaves = CompanyLeave::whereYear('leave_date', $year)
            ->whereMonth('leave_date', $month)
            ->select('leave_date', 'reason')
            ->get();

        // Get employee leave dates
        $absent = $this->getAbsent($year, $month, $appStartDate);
        $employeeLeaves = $this->getEmployeeLeaves($month, $year, );

        // Fetch attended dates for the given month and year
        $attendedDates = DutyStatus::where('user_id', Auth::id()) // Filter for logged-in user
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->pluck('date');

        return response()->json([
            'year' => $year,
            'month' => $month,
            'company_leaves' => $companyLeaves,
            'employee_absent' => $absent,
            'employee_leave' => $employeeLeaves,
            'attended_dates' => $attendedDates
        ]);
    }

    // private function getEmployeeLeaves($year, $month)
    // {
    //     // Step 1: Get all days of the given month
    //     $startDate = Carbon::create($year, $month, 1);
    //     $endDate = $startDate->copy()->endOfMonth();

    //     $allDates = [];
    //     for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
    //         $allDates[] = $date->format('Y-m-d');
    //     }

    //     // Step 2: Remove Sundays and 2nd & 4th Saturdays
    //     $filteredDates = array_filter($allDates, function ($date) {
    //         $day = Carbon::parse($date)->dayOfWeek;
    //         $weekOfMonth = ceil(Carbon::parse($date)->day / 7);

    //         // Exclude Sundays (dayOfWeek = 0) and 2nd/4th Saturdays (dayOfWeek = 6)
    //         return !($day == 0 || ($day == 6 && ($weekOfMonth == 2 || $weekOfMonth == 4)));
    //     });

    //     // Step 3: Exclude dates from duty_statuses table
    //     $dutyDates = DB::table('duty_statuses')
    //         ->whereYear('created_at', $year)
    //         ->whereMonth('created_at', $month)
    //         ->pluck('created_at')
    //         ->toArray();

    //     $filteredDates = array_diff($filteredDates, $dutyDates);

    //     // Step 4: Exclude company leaves
    //     $companyLeaves = DB::table('company_leaves')
    //         ->whereYear('leave_date', $year)
    //         ->whereMonth('leave_date', $month)
    //         ->pluck('leave_date')
    //         ->toArray();

    //     $filteredDates = array_diff($filteredDates, $companyLeaves);

    //     return array_values($filteredDates); // Return available leave dates
    // }


    private function getAbsent($year, $month, $appStartDate)
    {
        // Step 1: Get all days of the given month starting from app start date
        $startDate = Carbon::create($year, $month, 1);

        // Ensure start date is not before app start date
        if ($startDate->lt($appStartDate)) {
            $startDate = $appStartDate;
        }

        $endDate = Carbon::now()->endOfDay(); // Only consider dates up to today

        $allDates = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $allDates[] = $date->format('Y-m-d');
        }

        // Step 2: Remove Sundays and 2nd & 4th Saturdays
        $filteredDates = array_filter($allDates, function ($date) {
            $day = Carbon::parse($date)->dayOfWeek;
            $weekOfMonth = ceil(Carbon::parse($date)->day / 7);

            // Exclude Sundays (dayOfWeek = 0) and 2nd/4th Saturdays (dayOfWeek = 6)
            return !($day == 0 || ($day == 6 && ($weekOfMonth == 2 || $weekOfMonth == 4)));
        });

        // Step 3: Exclude dates from duty_statuses table (considering the app start date)
        $dutyDates = DB::table('duty_statuses')
            ->where('user_id', Auth::id()) // Filter for the logged-in user
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereDate('created_at', '>=', $appStartDate)
            ->whereDate('created_at', '<=', now())
            ->pluck('created_at')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();

        $filteredDates = array_diff($filteredDates, $dutyDates);

        // Step 4: Exclude company leaves (considering the app start date)
        $companyLeaves = DB::table('company_leaves')
            ->whereYear('leave_date', $year)
            ->whereMonth('leave_date', $month)
            ->whereDate('leave_date', '>=', $appStartDate)
            ->whereDate('leave_date', '<=', now())
            ->pluck('leave_date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();

        $filteredDates = array_diff($filteredDates, $companyLeaves);

        return array_values($filteredDates); // Return available leave dates
    }


    public function getEmployeeLeaves($month, $year)
    {
        $employeeLeaves = EmployeeLeave::where('user_id', Auth::id()) // Filter by logged-in user
            ->where(function ($query) use ($year, $month) {
                $query->whereYear('from_date', $year)
                    ->whereMonth('from_date', $month)
                    ->orWhereYear('to_date', $year)
                    ->whereMonth('to_date', $month);
            })
            ->get();
        $leaveDates = [];

        foreach ($employeeLeaves as $leave) {
            $startDate = Carbon::parse($leave->from_date);
            $endDate = Carbon::parse($leave->to_date);

            while ($startDate <= $endDate) {
                $leaveDates[] = [
                    'leave_date' => $startDate->toDateString(),
                    'remarks' => $leave->remarks,
                ];
                $startDate->addDay();
            }
        }

        // Convert to a collection if needed
        $leaveDatesCollection = collect($leaveDates);

        // Return or use the leaveDatesCollection
        return $leaveDatesCollection;
    }
}
