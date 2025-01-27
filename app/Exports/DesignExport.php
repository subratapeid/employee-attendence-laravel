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


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Carbon\Carbon;

class DesignExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents, WithMultipleSheets
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
        // Sample attendance data
        return collect([
            ['1', 'Employee-1', 'E0021', 'P', 'A', 'L', 'P', 'H', 'P', 'w', 3, 1, 1],
            ['2', 'Employee-2', 'E0022', 'P', 'P', 'L', 'P', 'H', 'A', 'w', 3, 1, 1],
        ]);
    }

    public function headings(): array
    {
        $dateRange = $this->getDateRange();

        return [
            array_merge(['SL No', 'Employee Name', 'Employee ID'], $dateRange, ['Total Present', 'Total Leave', 'Total Absent']),
            array_merge(['', '', ''], $this->getDayNames(count($dateRange)), ['', '', ''])
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $dateRange = $this->getDateRange();
        $lastColumn = Coordinate::stringFromColumnIndex(4 + count($dateRange)); // Dynamically calculate last column index

        // Merge header cells
        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells($lastColumn . '1:' . $lastColumn . '2'); // Total Present
        $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 1) . '2'); // Total Leave
        $sheet->mergeCells(Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '2'); // Total Absent

        // Styling headers
        $sheet->getStyle('A1:' . Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2) . '2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => 'center'],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9E1F2']], // Common BG color
            'borders' => ['allBorders' => ['borderStyle' => 'thin']]
        ]);

        // Different styling for day row (second row)
        $sheet->getStyle('D2:' . $lastColumn . '2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 10],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FFD966']], // Different BG color
        ]);

        // Auto fit content
        foreach (range('A', Coordinate::stringFromColumnIndex(4 + count($dateRange) + 2)) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Add "N/A" for future dates in current month filter
                $dateRange = $this->getDateRange();
                $today = Carbon::now()->day;
                if ($this->filterType === 'month') {
                    foreach ($dateRange as $index => $date) {
                        if ($date > $today) {
                            $column = Coordinate::stringFromColumnIndex(4 + $index); // Starting from column D
                            for ($row = 3; $row <= 10; $row++) {
                                $event->sheet->setCellValue("{$column}{$row}", 'N/A');
                            }
                        }
                    }
                }
            },
        ];
    }

    public function sheets(): array
    {
        $sheets = [];

        if ($this->filterType === 'year') {
            for ($month = 1; $month <= 12; $month++) {
                $sheets[] = new self('month', $month, $this->year);
            }
        } else {
            $sheets[] = new self('month', $this->month, $this->year);
        }

        return $sheets;
    }

    private function getDateRange()
    {
        if ($this->filterType === 'year') {
            return range(1, 31); // Full month days
        }

        $daysInMonth = Carbon::create($this->year, $this->month, 1)->daysInMonth;
        return range(1, $daysInMonth);
    }

    private function getDayNames($count)
    {
        $dayNames = [];
        for ($i = 1; $i <= $count; $i++) {
            $dayNames[] = Carbon::create($this->year, $this->month, $i)->format('D');
        }
        return $dayNames;
    }
}
