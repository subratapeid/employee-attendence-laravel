<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\UsersExport;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\MonthlyUserReportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendMonthlyUserReport extends Command
{
    protected $signature = 'report:send-monthly';  // <-- Add this line

    // The console command description
    protected $description = 'Generate and send the monthly user report.';

    public function handle()
    {
        Log::info('Scheduler is running!');
        // Get the current date and format it as you want
        $currentDate = now()->format('d-m-Y');  // Example: 22-01-2025
        $filePath = "reports/monthly_user_report-{$currentDate}.csv";

        // Ensure the 'reports' directory exists before storing the file
        if (!Storage::exists('reports')) {
            Storage::makeDirectory('reports');
        }

        try {
            $this->info('Generating the report...');

            // Generate and store the CSV file with a dynamic filename
            Excel::store(new UsersExport, $filePath, 'local');

            // Construct full path
            $fullPath = storage_path("app/private/{$filePath}");

            // Check if the file was actually created
            if (!file_exists($fullPath)) {
                $this->error("Failed to generate report. File not found at: {$fullPath}");
                return;
            }

            // If the file exists, send the email
            $this->info("Report successfully generated at: {$fullPath}");

            // Send email with the report
            Mail::to('subratap.eid@gmail.com')->send(new MonthlyUserReportMail($fullPath));

            $this->info('Monthly user report sent successfully.');

        } catch (\Exception $e) {
            $this->error("Error generating report: " . $e->getMessage());
        }
    }


}
