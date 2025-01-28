<?php
// namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithStyles;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\Events\AfterSheet;
// use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// class DesignExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
// {
//     public function collection()
//     {
//         return collect([
//             ['1', 'Employee-1', 'E0021', 'w', 'P', 'P', 'H', 'P', 'A', 'w', 3, 0, 1],
//             ['2', 'Employee-2', 'E0022', 'w', 'P', 'L', 'P', 'P', 'A', 'w', 3, 0, 1],
//         ]);
//     }

//     public function headings(): array
//     {
//         return [
//             ['SL No', 'Employee Name', 'Employee ID', '1', '2', '3', '4', '5', '6', '7', 'Total Present', 'Total Leave', 'Total Absent'],
//             ['', '', '', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', '', '', ''],
//         ];
//     }

//     public function styles(Worksheet $sheet)
//     {
//         // Merge cells for column titles
//         $sheet->mergeCells('A1:A2'); // SL No
//         $sheet->mergeCells('B1:B2'); // Employee Name
//         $sheet->mergeCells('C1:C2'); // Employee ID
//         $sheet->mergeCells('K1:K2'); // Total Present
//         $sheet->mergeCells('L1:L2'); // Total Leave
//         $sheet->mergeCells('M1:M2'); // Total Absent

//         // Bold headers and center alignment
//         $sheet->getStyle('A1:M2')->getFont()->setBold(true);
//         $sheet->getStyle('A1:M2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

//         // Column width adjustments for readability
//         $sheet->getColumnDimension('A')->setWidth(10);
//         $sheet->getColumnDimension('B')->setWidth(20);
//         $sheet->getColumnDimension('C')->setWidth(15);

//         // Color coding based on attendance values
//         $this->applyColorStyles($sheet);
//     }

//     private function applyColorStyles(Worksheet $sheet)
//     {
//         $statusColors = [
//             'P' => '00FF00',  // Green for Present
//             'A' => 'FF0000',  // Red for Absent
//             'L' => 'FFA500',  // Orange for Leave
//             'H' => 'FFFF00',  // Yellow for Holiday
//             'w' => 'ADD8E6',  // Light Blue for Weekends
//         ];

//         foreach ($statusColors as $letter => $color) {
//             for ($row = 3; $row <= 10; $row++) {
//                 for ($col = 'D'; $col <= 'J'; $col++) {
//                     $cell = "{$col}{$row}";
//                     if ($sheet->getCell($cell)->getValue() == $letter) {
//                         $sheet->getStyle($cell)->applyFromArray([
//                             'fill' => [
//                                 'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
//                                 'startColor' => ['argb' => $color]
//                             ]
//                         ]);
//                     }
//                 }
//             }
//         }
//     }

//     public function registerEvents(): array
//     {
//         return [
//             AfterSheet::class => function (AfterSheet $event) {
//                 // Set formula for total present count
//                 for ($row = 3; $row <= 10; $row++) {
//                     $event->sheet->getCell("K{$row}")->setValue('=COUNTIF(D' . $row . ':J' . $row . ',"P")');
//                     $event->sheet->getCell("L{$row}")->setValue('=COUNTIF(D' . $row . ':J' . $row . ',"L")');
//                     $event->sheet->getCell("M{$row}")->setValue('=COUNTIF(D' . $row . ':J' . $row . ',"A")');
//                 }
//             },
//         ];
//     }
// }


// namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithMultipleSheets;
// use Maatwebsite\Excel\Concerns\WithStyles;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\Events\AfterSheet;
// use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
// use Carbon\Carbon;

// class DesignExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents, WithMultipleSheets
// {
//     protected $filterType;
//     protected $month;
//     protected $year;

//     public function __construct($filterType, $month = null, $year = null)
//     {
//         $this->filterType = $filterType;
//         $this->month = $month;
//         $this->year = $year;
//     }

//     public function collection()
//     {
//         // Sample attendance data
//         return collect([
//             ['1', 'Employee-1', 'E0021', 'P', 'A', 'L', 'P', 'H', 'P', 'w', 3, 1, 1],
//             ['2', 'Employee-2', 'E0022', 'P', 'P', 'L', 'P', 'H', 'A', 'w', 3, 1, 1],
//         ]);
//     }

//     public function headings(): array
//     {
//         $dateRange = $this->getDateRange();

//         return [
//             array_merge(['SL No', 'Employee Name', 'Employee ID'], $dateRange, ['Total Present', 'Total Leave', 'Total Absent']),
//             array_merge(['', '', ''], $this->getDayNames(count($dateRange)), ['', '', ''])
//         ];
//     }

//     public function styles(Worksheet $sheet)
//     {
//         $dateRange = $this->getDateRange();
//         $lastColumn = Coordinate::stringFromColumnIndex(4 + count($dateRange)); // Dynamically calculate last column index

//         // Merge header cells
//         $sheet->mergeCells('A1:A2');
//         $sheet->mergeCells('B1:B2');
//         $sheet->mergeCells('C1:C2');
//         $sheet->mergeCells($lastColumn . '1:' . $lastColumn . '2'); // Total Present
//         $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1) . '2'); // Total Leave
//         $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '2'); // Total Absent

//         // Styling headers
//         $sheet->getStyle('A1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '2')->applyFromArray([
//             'font' => ['bold' => true, 'size' => 12],
//             'alignment' => ['horizontal' => 'center'],
//             'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9E1F2']], // Common BG color
//             'borders' => ['allBorders' => ['borderStyle' => 'thin']]
//         ]);

//         // Different styling for day row (second row)
//         $sheet->getStyle('D2:' . $lastColumn . '2')->applyFromArray([
//             'font' => ['bold' => true, 'size' => 10],
//             'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FFD966']], // Different BG color
//         ]);

//         // Auto fit content
//         foreach (range('A', Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2)) as $col) {
//             $sheet->getColumnDimension($col)->setAutoSize(true);
//         }
//     }

//     public function registerEvents(): array
//     {
//         return [
//             AfterSheet::class => function (AfterSheet $event) {
//                 // Add "N/A" for future dates in current month filter
//                 $dateRange = $this->getDateRange();
//                 $today = Carbon::now()->day;
//                 if ($this->filterType === 'month') {
//                     foreach ($dateRange as $index => $date) {
//                         if ($date > $today) {
//                             $column = Coordinate::stringFromColumnIndex(4 + $index); // Starting from column D
//                             for ($row = 3; $row <= 10; $row++) {
//                                 $event->sheet->setCellValue("{$column}{$row}", 'N/A');
//                             }
//                         }
//                     }
//                 }
//             },
//         ];
//     }

//     public function sheets(): array
//     {
//         $sheets = [];

//         if ($this->filterType === 'year') {
//             for ($month = 1; $month <= 12; $month++) {
//                 $sheets[] = new self('month', $month, $this->year);
//             }
//         } else {
//             $sheets[] = new self('month', $this->month, $this->year);
//         }

//         return $sheets;
//     }

//     private function getDateRange()
//     {
//         if ($this->filterType === 'year') {
//             return range(1, 31); // Full month days
//         }

//         $daysInMonth = Carbon::create($this->year, $this->month, 1)->daysInMonth;
//         return range(1, $daysInMonth);
//     }

//     private function getDayNames($count)
//     {
//         $dayNames = [];
//         for ($i = 1; $i <= $count; $i++) {
//             $dayNames[] = Carbon::create($this->year, $this->month, $i)->format('D');
//         }
//         return $dayNames;
//     }
// }






// namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithMultipleSheets;
// use Maatwebsite\Excel\Concerns\WithStyles;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\Events\AfterSheet;
// use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
// use Maatwebsite\Excel\Concerns\WithTitle;
// use Carbon\Carbon;

// class DesignExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize, WithEvents, WithMultipleSheets
// {
//     protected $filterType;
//     protected $month;
//     protected $year;

//     public function __construct($filterType, $month = null, $year = null)
//     {
//         $this->filterType = $filterType;
//         $this->month = $month;
//         $this->year = $year;
//     }

//     public function collection()
//     {
//         // Sample attendance data
//         return collect([
//             ['1', 'Employee-1', 'E0021', 'P', 'A', 'L', 'P', 'H', 'P', 'W', 'P', 'A', 'L', 'P', 'H', 'P', 'W', 'P', 'A', 'L', 'P', 'H', 'P', 'W', 'P', 'A', 'L', 'P', 'H', 'P', 'W', 3, 1, 1],
//             ['2', 'Employee-2', 'E0022', 'P', 'P', 'L', 'P', 'H', 'A', 'W', 'P', 'A', 'L', 'P', 'H', 'P', 'W', 'P', 'A', 'L', 'P', 'H', 'P', 'W', 'P', 'A', 'L', 'P', 'H', 'P', 'L', 3, 1, 1],
//         ]);
//     }

//     public function headings(): array
//     {
//         $dateRange = $this->getDateRange();

//         return [
//             array_merge(['SL No', 'Employee Name', 'Employee ID'], $dateRange, ['Total Present', 'Total Leave', 'Total Absent']),
//             array_merge(['', '', ''], $this->getDayNames(count($dateRange)), ['', '', '']),
//         ];
//     }

//     // public function styles(Worksheet $sheet)
//     // {
//     //     $dateRange = $this->getDateRange();
//     //     $lastColumn = Coordinate::stringFromColumnIndex(4 + count($dateRange));

//     //     // Merge header cells
//     //     $sheet->mergeCells('A1:A2');
//     //     $sheet->mergeCells('B1:B2');
//     //     $sheet->mergeCells('C1:C2');
//     //     $sheet->mergeCells($lastColumn . '1:' . $lastColumn . '2');
//     //     $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1) . '2');
//     //     $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '2');

//     //     // Styling headers
//     //     $sheet->getStyle('A1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '2')->applyFromArray([
//     //         'font' => ['bold' => true, 'size' => 12],
//     //         'alignment' => ['horizontal' => 'center'],
//     //         'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9E1F2']],
//     //         'borders' => ['allBorders' => ['borderStyle' => 'thin']],
//     //     ]);

//     //     // Different styling for the second row
//     //     $sheet->getStyle('D2:' . $lastColumn . '2')->applyFromArray([
//     //         'font' => ['bold' => true, 'size' => 10],
//     //         'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FFD966']],
//     //     ]);
//     // }


//     public function styles(Worksheet $sheet)
//     {
//         $dateRange = $this->getDateRange();
//         $lastColumn = Coordinate::stringFromColumnIndex(4 + count($dateRange)); // Last date column

//         // Merge header cells for date range
//         $sheet->mergeCells('A1:A2');
//         $sheet->mergeCells('B1:B2');
//         $sheet->mergeCells('C1:C2');
//         $sheet->mergeCells($lastColumn . '1:' . $lastColumn . '2');
//         $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1) . '2');
//         $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '2');
//         $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 3) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 3) . '2');

//         // Styling headers
//         $sheet->getStyle('A1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 3) . '2')->applyFromArray([
//             'font' => ['bold' => true, 'size' => 12],
//             'alignment' => ['horizontal' => 'center'],
//             'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9E1F2']],
//             'borders' => ['allBorders' => ['borderStyle' => 'thin']],
//         ]);

//         // Different styling for the second row (date range and totals headers)
//         $sheet->getStyle('D2:' . $lastColumn . '2')->applyFromArray([
//             'font' => ['bold' => true, 'size' => 10],
//             'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FFD966']],
//         ]);

//         // Merge two cells vertically for the Total columns (Total Present, Total Absent, Total Leave)
//         $totalsStartColumn = Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1); // After the last date column
//         $totalsEndColumn = Coordinate::stringFromColumnIndex(4 + count($dateRange) + 3); // Include all totals
//         $sheet->mergeCells("{$totalsStartColumn}1:{$totalsStartColumn}2"); // Total Present
//         $sheet->mergeCells("{$totalsStartColumn}3:{$totalsStartColumn}4"); // Merge for Total Present data
//         $sheet->mergeCells("{$totalsStartColumn}5:{$totalsStartColumn}6"); // Merge for Total Present data

//         $sheet->mergeCells("{$totalsEndColumn}1:{$totalsEndColumn}2"); // Total Leave
//         $sheet->mergeCells("{$totalsEndColumn}3:{$totalsEndColumn}4"); // Merge for Total Leave data
//         $sheet->mergeCells("{$totalsEndColumn}5:{$totalsEndColumn}6"); // Merge for Total Leave data

//         $sheet->mergeCells("{$totalsEndColumn}1:{$totalsEndColumn}2"); // Total Absent
//         $sheet->mergeCells("{$totalsEndColumn}3:{$totalsEndColumn}4"); // Merge for Total Absent data
//         $sheet->mergeCells("{$totalsEndColumn}5:{$totalsEndColumn}6"); // Merge for Total Absent data
//     }



//     public function registerEvents(): array
//     {
//         return [
//             AfterSheet::class => function (AfterSheet $event) {
//                 $sheet = $event->sheet->getDelegate();
//                 $dateRange = $this->getDateRange();
//                 $lastDateColumnIndex = 3 + count($dateRange); // Columns start at D (4th column)

//                 // Add "N/A" for future dates only in the current year's current month
//                 $today = Carbon::now();
//                 if (
//                     $this->filterType === 'month' &&
//                     $this->year == $today->year &&
//                     $this->month == $today->month
//                 ) {
//                     foreach ($dateRange as $index => $date) {
//                         if ($date > $today->day) { // Future dates in the current month
//                             $column = Coordinate::stringFromColumnIndex(4 + $index); // Starting from column D
//                             for ($row = 3; $row <= 10; $row++) {
//                                 $sheet->setCellValue("{$column}{$row}", 'N/A');
//                             }
//                         }
//                     }
//                 }

//                 // Apply conditional formatting for attendance markers
//                 foreach ($dateRange as $index => $date) {
//                     $column = Coordinate::stringFromColumnIndex(4 + $index); // Starting from column D
//                     for ($row = 3; $row <= 10; $row++) {
//                         $cell = "{$column}{$row}";
//                         $value = $sheet->getCell($cell)->getValue();
//                         switch ($value) {
//                             case 'P': // Present
//                                 $sheet->getStyle($cell)->applyFromArray([
//                                     'fill' => [
//                                         'fillType' => 'solid',
//                                         'startColor' => ['rgb' => 'C6EFCE'], // Light Green
//                                     ],
//                                 ]);
//                                 break;
//                             case 'L': // Leave
//                                 $sheet->getStyle($cell)->applyFromArray([
//                                     'fill' => [
//                                         'fillType' => 'solid',
//                                         'startColor' => ['rgb' => 'FFF2CC'], // Light Yellow
//                                     ],
//                                 ]);
//                                 break;
//                             case 'H': // Holiday
//                                 $sheet->getStyle($cell)->applyFromArray([
//                                     'fill' => [
//                                         'fillType' => 'solid',
//                                         'startColor' => ['rgb' => 'D9E1F2'], // Light Blue
//                                     ],
//                                 ]);
//                                 break;
//                             case 'W': // Weekly off
//                                 $sheet->getStyle($cell)->applyFromArray([
//                                     'fill' => [
//                                         'fillType' => 'solid',
//                                         'startColor' => ['rgb' => 'E7E6E6'], // Gray
//                                     ],
//                                 ]);
//                                 break;
//                         }
//                     }
//                 }

//                 // Fix totals column placement
//                 $totalsStartColumn = Coordinate::stringFromColumnIndex($lastDateColumnIndex + 1); // After last date
//                 $totalsEndColumn = Coordinate::stringFromColumnIndex($lastDateColumnIndex + 3); // Include all totals
//                 $sheet->mergeCells("{$totalsStartColumn}1:{$totalsEndColumn}1"); // Merge total column headers
//                 $sheet->getStyle("{$totalsStartColumn}1:{$totalsEndColumn}2")->applyFromArray([
//                     'font' => ['bold' => true],
//                     'alignment' => ['horizontal' => 'center'],
//                     'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9E1F2']], // Background for headers
//                     'borders' => ['allBorders' => ['borderStyle' => 'thin']],
//                 ]);
//             },
//         ];
//     }
//     public function sheets(): array
//     {
//         $sheets = [];

//         if ($this->filterType === 'year') {
//             $totalMonths = ($this->year == Carbon::now()->year) ? Carbon::now()->month : 12;

//             for ($month = 1; $month <= $totalMonths; $month++) {
//                 $sheets[] = new self('month', $month, $this->year);
//             }
//         } else {
//             $sheets[] = new self('month', $this->month, $this->year);
//         }

//         return $sheets;
//     }


//     public function title(): string
//     {
//         if ($this->filterType === 'year' && $this->month) {
//             return Carbon::create($this->year, $this->month)->format('F-Y'); // Example: January-2025
//         }

//         return Carbon::create($this->year, $this->month)->format('F-Y');
//     }

//     private function getDateRange()
//     {
//         if ($this->filterType === 'year') {
//             $currentMonth = Carbon::now()->month;
//             $monthsToInclude = range(1, $currentMonth);
//             return $monthsToInclude; // Limit to current month
//         }

//         $daysInMonth = Carbon::create($this->year, $this->month, 1)->daysInMonth;
//         return range(1, $daysInMonth);
//     }


//     private function getDayNames($count)
//     {
//         $dayNames = [];
//         for ($i = 1; $i <= $count; $i++) {
//             $dayNames[] = Carbon::create($this->year, $this->month, $i)->format('D');
//         }
//         return $dayNames;
//     }

//     private function getCellColor($value)
//     {
//         switch ($value) {
//             case 'P':
//                 return '00FF00'; // Green
//             case 'L':
//                 return 'FFFF00'; // Yellow
//             case 'H':
//                 return 'ADD8E6'; // Light Blue
//             case 'W':
//                 return 'FFA500'; // Orange
//             default:
//                 return '000000'; // Black
//         }
//     }
// }







// Working With example Data

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Carbon\Carbon;
use App\Models\DutyStatus;
use App\Models\EmployeeLeave;
use App\Models\CompanyLeave;

class DesignExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize, WithEvents
{
    protected $filterType;
    protected $month;
    protected $year;

    public function __construct($filterType, $month = null, $year = null)
    {
        $this->filterType = $filterType;
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        $employees = \App\Models\User::role('Employee')->get();
        // Get all employees (assuming you have an Employee model)

        $attendanceData = collect();  // Initialize empty collection to store attendance data

        foreach ($employees as $index => $employee) {
            $attendance = [$index + 1, $employee->name, $employee->id];

            $dateRange = $this->getDateRange(); // Get the date range for the month

            foreach ($dateRange as $day) {
                $date = Carbon::create($this->year, $this->month, $day);

                // Check if the date is a Sunday or 2nd/4th Saturday
                $status = $this->getWeekendStatus($date);

                // Check if the employee has duty for the day
                if (
                    DutyStatus::where('user_id', $employee->id)
                        ->whereDate('created_at', $date->toDateString())->exists()
                ) {
                    $status = 'P'; // Present
                }

                // Check if the employee has applied for leave on that day
                if (
                    EmployeeLeave::where('user_id', $employee->id)
                        ->whereDate('from_date', '<=', $date->toDateString()) // The date should be after or on the from_date
                        ->whereDate('to_date', '>=', $date->toDateString()) // The date should be before or on the to_date
                        ->exists()
                ) {
                    $status = 'L'; // Leave
                }


                // Check if it's a company leave day
                if (CompanyLeave::whereDate('leave_date', $date->toDateString())->exists()) {
                    $status = 'H'; // Holiday (Company Leave)
                }

                // Add status to attendance data
                $attendance[] = $status;
            }

            // Add totals
            $totalPresent = count(array_filter($attendance, fn($status) => $status === 'P'));
            $totalLeave = count(array_filter($attendance, fn($status) => $status === 'L'));
            $totalAbsent = count(array_filter($attendance, fn($status) => $status === 'A'));

            // Append total counts to the data
            $attendance[] = $totalPresent;
            $attendance[] = $totalLeave;
            $attendance[] = $totalAbsent;

            $attendanceData->push($attendance); // Add employee's data to collection
        }

        return $attendanceData;
    }

    private function getWeekendStatus($date)
    {
        // Check if the date is Sunday or the 2nd/4th Saturday
        if ($date->isSunday()) {
            return 'W'; // Sunday
        }

        // Check for 2nd and 4th Saturday
        $weekOfMonth = $date->weekOfMonth;
        if (($weekOfMonth == 2 || $weekOfMonth == 4) && $date->isSaturday()) {
            return 'W'; // Saturday (2nd or 4th)
        }

        return 'A'; // Default to Absent
    }

    public function headings(): array
    {
        $dateRange = $this->getDateRange();
        return [
            array_merge(['SL No', 'Employee Name', 'Employee ID'], $dateRange, ['Total Present', 'Total Leave', 'Total Absent']),
            array_merge(['', '', ''], $this->getDayNames(count($dateRange)), ['', '', '']),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $dateRange = $this->getDateRange();
        // Calculate the last column based on the number of dates + other columns
        $lastColumn = Coordinate::stringFromColumnIndex(4 + count($dateRange)); // Last date column

        // Get the last row with data
        $lastRow = $sheet->getHighestRow(); // Get the last row of data

        // Merge header cells for date range
        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells($lastColumn . '1:' . $lastColumn . '2');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1) . '2');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '2');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 3) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 3) . '2');

        // Styling headers
        $sheet->getStyle('A1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 3) . '2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'middle'],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E6E6E6']],
            'borders' => ['allBorders' => ['borderStyle' => 'thin']],
        ]);

        // Different styling for the second row (date range and totals headers)
        $sheet->getStyle('D2:' . $lastColumn . '2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 10],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FFFFCC']],
        ]);

        // Apply borders for the entire data range dynamically
        $sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin'],
            ],
        ]);
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $dateRange = $this->getDateRange();
                $lastDateColumnIndex = 3 + count($dateRange); // Columns start at D (4th column)
    
                // Add "N/A" for future dates only in the current month's current year
                $today = Carbon::now();
                if (
                    $this->filterType === 'month' &&
                    $this->year == $today->year &&
                    $this->month == $today->month
                ) {
                    foreach ($dateRange as $index => $date) {
                        if ($date > $today->day) { // Future dates in the current month
                            $column = Coordinate::stringFromColumnIndex(4 + $index); // Starting from column D
                            // Loop over each row dynamically based on employee count
                            foreach ($event->sheet->getRowIterator() as $rowIndex => $row) {
                                if ($rowIndex >= 3) { // Start from the 3rd row, assuming the first two rows are headers
                                    $sheet->setCellValue("{$column}{$rowIndex}", 'N/A');
                                }
                            }
                        }
                    }
                }

                // Apply conditional formatting for attendance markers
                foreach ($dateRange as $index => $date) {
                    $column = Coordinate::stringFromColumnIndex(4 + $index); // Starting from column D
                    // Loop over each row dynamically based on employee count
                    foreach ($event->sheet->getRowIterator() as $rowIndex => $row) {
                        if ($rowIndex >= 3) { // Start from the 3rd row, assuming the first two rows are headers
                            $cell = "{$column}{$rowIndex}";
                            $value = $sheet->getCell($cell)->getValue();
                            switch ($value) {
                                case 'P': // Present
                                    $sheet->getStyle($cell)->applyFromArray([
                                        'fill' => [
                                            'fillType' => 'solid',
                                            'startColor' => ['rgb' => '17E500'], //  Green
                                        ],
                                    ]);
                                    break;
                                case 'A': // Absent
                                    $sheet->getStyle($cell)->applyFromArray([
                                        'fill' => [
                                            'fillType' => 'solid',
                                            'startColor' => ['rgb' => 'F44141'], // Red
                                        ],
                                    ]);
                                    break;
                                case 'L': // Leave
                                    $sheet->getStyle($cell)->applyFromArray([
                                        'fill' => [
                                            'fillType' => 'solid',
                                            'startColor' => ['rgb' => 'FF5ECF'], // Pink
                                        ],
                                    ]);
                                    break;
                                case 'H': // Holiday
                                    $sheet->getStyle($cell)->applyFromArray([
                                        'fill' => [
                                            'fillType' => 'solid',
                                            'startColor' => ['rgb' => 'FF9354'], // Light orange
                                        ],
                                    ]);
                                    break;
                                case 'W': // Weekly off
                                    $sheet->getStyle($cell)->applyFromArray([
                                        'fill' => [
                                            'fillType' => 'solid',
                                            'startColor' => ['rgb' => 'F3FF37'], // Light Yellow
                                        ],
                                    ]);
                                    break;
                                case 'N/A': // Future Date
                                    $sheet->getStyle($cell)->applyFromArray([
                                        'fill' => [
                                            'fillType' => 'solid',
                                            'startColor' => ['rgb' => 'DADADA'], // grey
                                        ],
                                    ]);
                                    break;
                            }
                        }
                    }
                }


                // Manually calculating totals
                $totalRow = 3 + count($this->collection()); // Total data starts below the last row of data
    
                foreach ($this->collection() as $index => $row) {
                    $employeeRow = 3 + $index; // Employee data starts from row 3
    
                    // Count the occurrences of Present, Leave, Absent
                    $totalPresent = 0;
                    $totalLeave = 0;
                    $totalAbsent = 0;

                    foreach ($row as $i => $status) {
                        if ($i >= 3 && $i < 3 + count($dateRange)) {
                            if ($status === 'P') {
                                $totalPresent++;
                            } elseif ($status === 'L') {
                                $totalLeave++;
                            } elseif ($status === 'A') {
                                $totalAbsent++;
                            }
                        }
                    }

                    // Set the totals for each employee
                    $sheet->setCellValueByColumnAndRow($lastDateColumnIndex + 1, $employeeRow, $totalPresent);
                    $sheet->setCellValueByColumnAndRow($lastDateColumnIndex + 2, $employeeRow, $totalLeave);
                    $sheet->setCellValueByColumnAndRow($lastDateColumnIndex + 3, $employeeRow, $totalAbsent);
                }
            },
        ];
    }

    public function title(): string
    {
        if ($this->filterType === 'year') {
            return Carbon::create($this->year, $this->month)->format('F-Y'); // Example: January-2025
        }

        return Carbon::create($this->year, $this->month)->format('F-Y');
    }

    private function getDateRange()
    {
        if ($this->filterType === 'year') {
            $currentMonth = Carbon::now()->month;
            $monthsToInclude = range(1, $currentMonth);
            return $monthsToInclude; // Limit to current month
        }

        $daysInMonth = Carbon::create($this->year, $this->month, 1)->daysInMonth;
        return range(1, $daysInMonth); // Range of days in the selected month
    }

    private function getDayNames($count)
    {
        return array_map(function ($i) {
            return Carbon::create($this->year, $this->month, $i)->format('D');
        }, range(1, $count));
    }
}



// Trying with data from DB

// 


// namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithTitle;
// use Maatwebsite\Excel\Concerns\WithStyles;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\Events\AfterSheet;
// use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
// use Carbon\Carbon;
// use App\Models\DutyStatus;
// use App\Models\EmployeeLeave;
// use App\Models\CompanyLeave;

// class DesignExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize, WithEvents
// {
//     protected $filterType;
//     protected $month;
//     protected $year;

//     public function __construct($filterType, $month = null, $year = null)
//     {
//         $this->filterType = $filterType;
//         $this->month = $month;
//         $this->year = $year;
//     }

//     public function collection()
//     {
//         $employees = \App\Models\User::role('Employee')->get();
//         // Get all employees (assuming you have an Employee model)

//         $attendanceData = collect();  // Initialize empty collection to store attendance data

//         foreach ($employees as $employee) {
//             $attendance = [$employee->id, $employee->name, $employee->employee_id];

//             $dateRange = $this->getDateRange(); // Get the date range for the month

//             foreach ($dateRange as $day) {
//                 $date = Carbon::create($this->year, $this->month, $day);

//                 // Check if the date is a Sunday or 2nd/4th Saturday
//                 $status = $this->getWeekendStatus($date);

//                 // Check if the employee has duty for the day
//                 if (
//                     DutyStatus::where('user_id', $employee->id)
//                         ->whereDate('created_at', $date->toDateString())->exists()
//                 ) {
//                     $status = 'P'; // Present
//                 }

//                 // Check if the employee has applied for leave on that day
//                 if (
//                     EmployeeLeave::where('user_id', $employee->id)
//                         ->whereDate('from_date', $date->toDateString())->exists()
//                 ) {
//                     $status = 'L'; // Leave
//                 }

//                 // Check if it's a company leave day
//                 if (CompanyLeave::whereDate('leave_date', $date->toDateString())->exists()) {
//                     $status = 'H'; // Holiday (Company Leave)
//                 }

//                 // Add status to attendance data
//                 $attendance[] = $status;
//             }

//             // Add totals
//             $totalPresent = count(array_filter($attendance, fn($status) => $status === 'P'));
//             $totalLeave = count(array_filter($attendance, fn($status) => $status === 'L'));
//             $totalAbsent = count(array_filter($attendance, fn($status) => $status === 'A'));

//             // Append total counts to the data
//             $attendance[] = $totalPresent;
//             $attendance[] = $totalLeave;
//             $attendance[] = $totalAbsent;

//             $attendanceData->push($attendance); // Add employee's data to collection
//         }

//         return $attendanceData;
//     }

//     public function headings(): array
//     {
//         $dateRange = $this->getDateRange();
//         return [
//             array_merge(['SL No', 'Employee Name', 'Employee ID'], $dateRange, ['Total Present', 'Total Leave', 'Total Absent']),
//             array_merge(['', '', ''], $this->getDayNames(count($dateRange)), ['', '', '']),
//         ];
//     }

//     public function styles(Worksheet $sheet)
//     {
//         $dateRange = $this->getDateRange();
//         $lastColumn = Coordinate::stringFromColumnIndex(4 + count($dateRange)); // Last date column

//         // Merge header cells for date range
//         $sheet->mergeCells('A1:A2');
//         $sheet->mergeCells('B1:B2');
//         $sheet->mergeCells('C1:C2');
//         $sheet->mergeCells($lastColumn . '1:' . $lastColumn . '2');
//         $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1) . '2');
//         $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '2');
//         $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 3) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 3) . '2');

//         // Styling headers
//         $sheet->getStyle('A1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 3) . '2')->applyFromArray([
//             'font' => ['bold' => true, 'size' => 12],
//             'alignment' => ['horizontal' => 'center'],
//             'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9E1F2']],
//             'borders' => ['allBorders' => ['borderStyle' => 'thin']],
//         ]);

//         // Different styling for the second row (date range and totals headers)
//         $sheet->getStyle('D2:' . $lastColumn . '2')->applyFromArray([
//             'font' => ['bold' => true, 'size' => 10],
//             'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FFD966']],
//         ]);
//     }

//     public function registerEvents(): array
//     {
//         return [
//             AfterSheet::class => function (AfterSheet $event) {
//                 // Your existing AfterSheet logic here...
//             },
//         ];
//     }

//     public function title(): string
//     {
//         if ($this->filterType === 'year') {
//             return Carbon::create($this->year, $this->month)->format('F-Y'); // Example: January-2025
//         }

//         return Carbon::create($this->year, $this->month)->format('F-Y');
//     }

//     private function getDateRange()
//     {
//         if ($this->filterType === 'year') {
//             $currentMonth = Carbon::now()->month;
//             $monthsToInclude = range(1, $currentMonth);
//             return $monthsToInclude; // Limit to current month
//         }

//         $daysInMonth = Carbon::create($this->year, $this->month, 1)->daysInMonth;
//         return range(1, $daysInMonth); // Range of days in the selected month
//     }

//     private function getDayNames($count)
//     {
//         return array_map(function ($i) {
//             return Carbon::create($this->year, $this->month, $i)->format('D');
//         }, range(1, $count));
//     }

// private function getWeekendStatus($date)
// {
//     // Check if the date is Sunday or the 2nd/4th Saturday
//     if ($date->isSunday()) {
//         return 'W'; // Sunday
//     }

//     // Check for 2nd and 4th Saturday
//     $weekOfMonth = $date->weekOfMonth;
//     if (($weekOfMonth == 2 || $weekOfMonth == 4) && $date->isSaturday()) {
//         return 'W'; // Saturday (2nd or 4th)
//     }

//     return 'A'; // Default to Absent
// }
// }
