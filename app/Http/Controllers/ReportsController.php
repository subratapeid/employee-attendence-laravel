<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\AttendanceExport;
use App\Exports\ActivityExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DesignExport;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class ReportsController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view-report', only: ['index']),
            // new Middleware('permission:edit-reports', only: ['edit']),
        ];
    }
    // function to view the reports page
    public function index()
    {
        return view('pages.reports');
    }

    // Handle the filtered report request (if needed)
    public function getFilteredReport(Request $request)
    {
        $filter = $request->input('filter');
        $report = $request->input('report');

        // If 'both' is requested, fetch data for both reports
        if ($report == 'both') {
            $attendanceData = $this->getAttendanceData($filter);
            $activityData = $this->getActivityData($filter);

            return response()->json([
                'attendance' => $attendanceData,
                'activity' => $activityData
            ]);
        }

        // If specific report is requested
        if ($report == 'attendance') {
            $data = $this->getAttendanceData($filter);
        } else {
            $data = $this->getActivityData($filter);
        }

        return response()->json($data);
    }

    // Export report using Maatwebsite Excel
// In ReportsController.php
public function exportCSV(Request $request)
{
    $report = $request->input('report');         // 'attendance' or 'activity'
    $filterDate = $request->input('filter');     // '2025-04-03' or 'today' or 'yesterday'

    $formattedDate = '';

    if ($report === 'activity') {
        // For activity, just one date in format: (04-April-2025)
        if ($filterDate === 'today') {
            $formattedDate = Carbon::today()->format('d-F-Y');
        } elseif ($filterDate === 'yesterday') {
            $formattedDate = Carbon::yesterday()->format('d-F-Y');
        } else {
            $formattedDate = Carbon::parse($filterDate)->format('d-F-Y');
        }

        $fileName = 'activity_report(' . $formattedDate . ').xlsx';
        return Excel::download(new ActivityExport($filterDate), $fileName);

    } else {
        // For attendance, full month range: (01-April-2025 to 30-April-2025)
        try {
            $carbonDate = Carbon::parse($filterDate);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid date provided.'], 400);
        }

        $startOfMonth = $carbonDate->copy()->startOfMonth()->format('d-F-Y');
        $endOfMonth = $carbonDate->copy()->endOfMonth()->format('d-F-Y');

        $fileName = 'attendance_report(' . $startOfMonth . ' to ' . $endOfMonth . ').xlsx';
        return Excel::download(new AttendanceExport($filterDate), $fileName);
    }
}



    private function getAttendanceData($filter)
    {
        // Fetch attendance data based on the filter
        $attendance = User::where('created_at', '>=', now()->startOfMonth())->get();
        return $attendance;
    }

    private function getActivityData($filter)
    {
        // Fetch activity data based on the filter
        $activity = User::where('created_at', '>=', now()->startOfMonth())->get();
        return $activity;
    }


    public function export(Request $request)
    {
        $reportType = $request->query('report', 'attendance');
        $filter = $request->query('filter', 'this_month');

        $month = null;
        $year = Carbon::now()->year;

        switch ($filter) {
            case 'this_year':
                $filterType = 'year';
                break;
            case 'previous_year':
                $filterType = 'year';
                $year = Carbon::now()->subYear()->year;
                break;
            case 'this_month':
                $filterType = 'month';
                $month = Carbon::now()->month;
                break;
            case 'previous_month':
                $filterType = 'month';
                $month = Carbon::now()->subMonth()->month;
                break;
            case 'today':
                $filterType = 'month';
                $month = Carbon::now()->month;
                break;
            case 'this_week':
            case 'last_week':
                // Customize for weekly filtering if needed.
                // Example: Implement weekly logic based on Carbon here.
                $filterType = 'month';
                $month = Carbon::now()->month;
                break;
            default:
                $filterType = 'month';
                $month = Carbon::now()->month;
        }

        return Excel::download(new DesignExport($filterType, $month, $year), "{$reportType}_report.xlsx");
    }

}
