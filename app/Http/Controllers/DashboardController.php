<?php

namespace App\Http\Controllers;

use App\Models\CompanyLeave;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getTotalWorkingHours(Request $request)
    {
        // Determine the filter type
        $filter = $request->input('filter', 'today'); // Default filter is 'today'

        // Initialize date range
        $startDate = null;
        $endDate = null;

        // Set date range based on the filter
        switch ($filter) {
            case 'this_week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'this_month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'this_year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            case 'custom':
                $startDate = Carbon::parse($request->input('start_date'));
                $endDate = Carbon::parse($request->input('end_date'));
                break;
            case 'today':
            default:
                $startDate = Carbon::today()->startOfDay();
                $endDate = Carbon::today()->endOfDay();
                break;
        }

        // Fetch duty records for the authenticated user within the date range
        $records = Attendance::where('user_id', auth()->id())
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Calculate total working hours in minutes
        $totalWorkingMinutes = $records->reduce(function ($carry, $record) {
            return $carry + $record->created_at->diffInMinutes($record->end_time);
        }, 0);

        // Convert minutes to hours and minutes
        $hours = floor($totalWorkingMinutes / 60);
        $minutes = $totalWorkingMinutes % 60;

        // Return the response
        return response()->json([
            'filter' => $filter,
            'total_working_hours' => "{$hours} hours, {$minutes} minutes",
            'total_working_minutes' => $totalWorkingMinutes,
            'date_range' => [
                'start' => $startDate->toDateString(),
                'end' => $endDate->toDateString(),
            ],
        ]);
    }

    // get attendence count
    public function getAttendanceCount(Request $request)
    {
        // Default filter is this week
        $filter = $request->get('filter', 'this_week');

        // Determine the date range based on the filter
        $startDate = null;
        $endDate = null;

        switch ($filter) {
            case 'this_month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'this_year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            case 'custom':
                $startDate = Carbon::parse($request->get('start_date'));
                $endDate = Carbon::parse($request->get('end_date'));
                break;
            case 'this_week':
            default:
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
        }

        // Query attendance records for the authenticated user within the date range
        $attendanceCount = Attendance::where('user_id', auth()->id())
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($record) {
                return $record->created_at->toDateString(); // Group by date (YYYY-MM-DD)
            })
            ->count(); // Count unique dates

        return response()->json([
            'filter' => $filter,
            'attendance_count' => $attendanceCount,
            'date_range' => [
                'start' => $startDate->toDateString(),
                'end' => $endDate->toDateString(),
            ],
        ]);
    }


    // // get leave count
    // public function getTotalLeaves(Request $request)
    // {
    //     $filter = $request->input('filter', 'this_week'); // Default filter is 'this_week'
    //     $userId = auth()->id(); // Assuming the user is authenticated

    //     // Get the start and end dates based on the filter
    //     $startDate = null;
    //     $endDate = Carbon::now();

    //     switch ($filter) {
    //         case 'this_week':
    //             $startDate = Carbon::now()->startOfWeek();
    //             break;

    //         case 'this_month':
    //             $startDate = Carbon::now()->startOfMonth();
    //             break;

    //         case 'this_year':
    //             $startDate = Carbon::now()->startOfYear();
    //             break;

    //         default:
    //             return response()->json(['error' => 'Invalid filter'], 400);
    //     }

    //     // Generate an array of dates between start and end dates
    //     $dates = [];
    //     $currentDate = $startDate->copy();
    //     while ($currentDate <= $endDate) {
    //         $dates[] = $currentDate->format('Y-m-d');
    //         $currentDate->addDay();
    //     }

    //     // Count the days that have no attendance records for the user
    //     $leaveCount = 0;
    //     foreach ($dates as $date) {
    //         $attendanceRecord = Attendance::where('user_id', $userId)
    //             ->whereDate('created_at', $date)
    //             ->first();

    //         if (!$attendanceRecord) {
    //             $leaveCount++; // Increment leave count if no attendance record is found
    //         }
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'leave_count' => $leaveCount,
    //     ]);
    // }


    // Get leave count
    public function getTotalLeaves(Request $request)
    {
        $filter = $request->input('filter', 'this_week'); // Default filter is 'this_week'
        $userId = auth()->id(); // Assuming the user is authenticated

        // Get the application start date from .env
        $appStartDate = Carbon::parse(env('APP_START_DATE', '2025-01-01'));

        // Get the start and end dates based on the filter
        $startDate = null;
        $endDate = Carbon::now();

        switch ($filter) {
            case 'this_week':
                $startDate = Carbon::now()->startOfWeek();
                break;

            case 'this_month':
                $startDate = Carbon::now()->startOfMonth();
                break;

            case 'this_year':
                $startDate = Carbon::now()->startOfYear();
                break;

            default:
                return response()->json(['error' => 'Invalid filter'], 400);
        }

        // Ensure the start date is not before the application start date
        if ($startDate < $appStartDate) {
            $startDate = $appStartDate;
        }

        // Generate an array of dates between start and end dates
        $dates = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // Remove Sundays and 2nd & 4th Saturdays
        $filteredDates = array_filter($dates, function ($date) {
            $carbonDate = Carbon::parse($date);
            $dayOfWeek = $carbonDate->dayOfWeek;
            $weekOfMonth = ceil($carbonDate->day / 7);

            // Exclude Sundays (dayOfWeek = 0) and 2nd & 4th Saturdays (dayOfWeek = 6)
            return !($dayOfWeek == 0 || ($dayOfWeek == 6 && ($weekOfMonth == 2 || $weekOfMonth == 4)));
        });

        // Fetch company leave dates from the database
        $companyLeaves = CompanyLeave::whereBetween('leave_date', [$startDate, $endDate])
            ->pluck('leave_date')
            ->toArray();

        // Remove company leaves from the filtered dates
        $availableDates = array_diff($filteredDates, $companyLeaves);

        // Count the days that have no attendance records for the user
        $leaveCount = 0;
        foreach ($availableDates as $date) {
            $attendanceRecord = Attendance::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->first();

            if (!$attendanceRecord) {
                $leaveCount++; // Increment leave count if no attendance record is found
            }
        }

        return response()->json([
            'success' => true,
            'leave_count' => $leaveCount,
        ]);
    }



    public function getLateArrivals(Request $request)
    {
        $filter = $request->input('filter', 'this_week'); // Default filter is 'this_week'
        $userId = auth()->id(); // Assuming the user is authenticated

        // Get the start and end dates based on the filter
        $startDate = null;
        $endDate = Carbon::now();

        switch ($filter) {
            case 'this_week':
                $startDate = Carbon::now()->startOfWeek();
                break;

            case 'this_month':
                $startDate = Carbon::now()->startOfMonth();
                break;

            case 'this_year':
                $startDate = Carbon::now()->startOfYear();
                break;

            default:
                return response()->json(['error' => 'Invalid filter'], 400);
        }

        // Generate an array of dates between start and end dates
        $dates = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // Count late arrivals (created_at after 9:30 AM)
        $lateCount = 0;
        foreach ($dates as $date) {
            $attendanceRecord = Attendance::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->first();

            if ($attendanceRecord && $attendanceRecord->created_at->gt(Carbon::parse($date . ' 09:30:00'))) {
                $lateCount++;
            }
        }

        return response()->json([
            'success' => true,
            'late_arrival_count' => $lateCount,
        ]);
    }

    /**
     * Fetch total early departures based on filter.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEarlyDepartures(Request $request)
    {
        $filter = $request->input('filter', 'this_week'); // Default filter is 'this_week'
        $userId = auth()->id(); // Assuming the user is authenticated

        // Get the start and end dates based on the filter
        $startDate = null;
        $endDate = Carbon::now();

        switch ($filter) {
            case 'this_week':
                $startDate = Carbon::now()->startOfWeek();
                break;

            case 'this_month':
                $startDate = Carbon::now()->startOfMonth();
                break;

            case 'this_year':
                $startDate = Carbon::now()->startOfYear();
                break;

            default:
                return response()->json(['error' => 'Invalid filter'], 400);
        }

        // Generate an array of dates between start and end dates
        $dates = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // Count early departures (end_time before 6:30 PM)
        $earlyCount = 0;
        foreach ($dates as $date) {
            $attendanceRecord = Attendance::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->first();

            if ($attendanceRecord) {
                // Cast end_time to Carbon instance
                $endTime = Carbon::parse($attendanceRecord->end_time);

                // Check if end_time is before 6:30 PM
                if ($endTime->lt(Carbon::parse($date . ' 18:30:00'))) {
                    $earlyCount++;
                }
            }
        }

        return response()->json([
            'success' => true,
            'early_departure_count' => $earlyCount,
        ]);
    }

    // Get Overtime duty
    // public function getOvertime(Request $request)
    // {
    //     $filter = $request->get('filter', 'this_week');

    //     // Determine the start and end dates for the filter
    //     $startDate = Carbon::now()->startOfWeek();
    //     $endDate = Carbon::now()->endOfWeek();

    //     if ($filter === 'this_month') {
    //         $startDate = Carbon::now()->startOfMonth();
    //         $endDate = Carbon::now()->endOfMonth();
    //     } elseif ($filter === 'this_year') {
    //         $startDate = Carbon::now()->startOfYear();
    //         $endDate = Carbon::now()->endOfYear();
    //     } elseif ($filter === 'custom') {
    //         $startDate = Carbon::parse($request->get('start_date'));
    //         $endDate = Carbon::parse($request->get('end_date'));
    //     }

    //     // Fetch attendance records within the date range
    //     $attendanceRecords = Attendance::where('user_id', auth()->id())
    //         ->whereDate('created_at', '>=', $startDate)
    //         ->whereDate('created_at', '<=', $endDate)
    //         ->get();

    //     $totalOvertimeMinutes = 0;
    //     $standardDutyMinutes = 8 * 60 + 30; // 8 hours 30 minutes in minutes

    //     foreach ($attendanceRecords as $record) {
    //         $startTime = Carbon::parse($record->created_at);
    //         $endTime = Carbon::parse($record->end_time);

    //         // Calculate total worked minutes
    //         $workedMinutes = $startTime->diffInMinutes($endTime);

    //         // Calculate overtime only if worked minutes exceed standard duty minutes
    //         if ($workedMinutes > $standardDutyMinutes) {
    //             $overtimeMinutes = $workedMinutes - $standardDutyMinutes;
    //             $totalOvertimeMinutes += $overtimeMinutes;
    //         }
    //     }

    //     // Convert total overtime minutes to hours and minutes
    //     $overtimeHours = floor($totalOvertimeMinutes / 60);
    //     $overtimeRemainingMinutes = $totalOvertimeMinutes % 60;

    //     return response()->json([
    //         'status' => 'success',
    //         'total_overtime' => "{$overtimeHours} hours, {$overtimeRemainingMinutes} minutes"

    //     ]);
    // }


    public function getOvertime(Request $request)
    {
        $filter = $request->get('filter', 'this_week');

        // Determine the start and end dates for the filter
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        if ($filter === 'this_month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($filter === 'this_year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } elseif ($filter === 'custom') {
            $startDate = Carbon::parse($request->get('start_date'));
            $endDate = Carbon::parse($request->get('end_date'));
        }

        // Fetch attendance records within the date range
        $attendanceRecords = Attendance::where('user_id', auth()->id())
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

        $totalOvertimeMinutes = 0;
        $standardDutyMinutes = 8 * 60 + 30; // 8 hours 30 minutes in minutes

        // Group attendance records by date
        $attendanceGroupedByDate = $attendanceRecords->groupBy(function ($attendance) {
            return Carbon::parse($attendance->created_at)->toDateString();
        });

        // Iterate through each group (by day) to calculate total worked minutes
        foreach ($attendanceGroupedByDate as $date => $records) {
            $totalWorkedMinutesForDay = 0;

            foreach ($records as $record) {
                $startTime = Carbon::parse($record->created_at);
                $endTime = Carbon::parse($record->end_time);

                // Calculate total worked minutes for the record
                $workedMinutes = $startTime->diffInMinutes($endTime);

                // Add to the total worked minutes for the day
                $totalWorkedMinutesForDay += $workedMinutes;
            }

            // Calculate overtime only if total worked minutes exceed standard duty minutes
            if ($totalWorkedMinutesForDay > $standardDutyMinutes) {
                $overtimeMinutes = $totalWorkedMinutesForDay - $standardDutyMinutes;
                $totalOvertimeMinutes += $overtimeMinutes;
            }
        }

        // Convert total overtime minutes to hours and minutes
        $overtimeHours = floor($totalOvertimeMinutes / 60);
        $overtimeRemainingMinutes = $totalOvertimeMinutes % 60;

        return response()->json([
            'status' => 'success',
            'total_overtime' => "{$overtimeHours} hours, {$overtimeRemainingMinutes} minutes"
        ]);
    }

    public function getDashboardData(Request $request)
    {

        // Call each individual function with the filter string passed
        $totalWorkingHours = $this->getTotalWorkingHours($request)->original['total_working_hours'];
        $attendanceCount = $this->getAttendanceCount($request)->original['attendance_count'];
        $totalLeaves = $this->getTotalLeaves($request)->original['leave_count'];
        $lateArrivals = $this->getLateArrivals($request)->original['late_arrival_count'];
        $earlyDepartures = $this->getEarlyDepartures($request)->original['early_departure_count'];
        $overtime = $this->getOvertime($request)->original['total_overtime'];

        // Simplified response format
        return response()->json([
            'success' => true,
            'total_working_hours' => $totalWorkingHours,
            'attendance_count' => $attendanceCount,
            'total_leaves' => $totalLeaves,
            'late_arrival_count' => $lateArrivals,
            'early_departure_count' => $earlyDepartures,
            'overtime' => $overtime,
        ]);
    }



}
