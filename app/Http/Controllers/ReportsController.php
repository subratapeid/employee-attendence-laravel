<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\AttendanceExport;
use App\Exports\ActivityExport;
use Maatwebsite\Excel\Facades\Excel;


class ReportsController extends Controller
{
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
    public function exportCSV(Request $request)
    {
        $report = $request->input('report');
        $filter = $request->input('filter');

        // Determine which export to use based on the report type
        if ($report == 'attendance') {
            return Excel::download(new AttendanceExport($filter), 'attendance_report_' . $filter . '.xlsx');
        } else {
            return Excel::download(new ActivityExport($filter), 'activity_report_' . $filter . '.xlsx');
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
}
