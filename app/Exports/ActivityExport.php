<?php

namespace App\Exports;

use App\Models\DayStartEnd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class ActivityExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $date;

    public function __construct($date = null)
    {
        $this->date = $date; // e.g. '2025-04-04'
    }

    public function collection()
    {
        $query = DayStartEnd::with('user');

        // Handle different date filters
        if ($this->date === 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($this->date === 'yesterday') {
            $query->whereDate('created_at', Carbon::yesterday());
        } elseif ($this->isValidDateFormat($this->date, 'Y-m-d')) {
            $query->whereDate('created_at', $this->date);
        }

        return $query->get()->map(function ($record) {
            return [
                'Name'       => $record->user->name ?? '',
                'Email'      => $record->user->email ?? '',
                'Emp ID'     => $record->user->emp_id ?? '',
                'Phone'      => $record->user->phone ?? '',
                'Start Time' => $record->start_time,
                'End Time'   => $record->end_time,
                'Date'       => $record->date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Emp ID',
            'Phone',
            'Start Time',
            'End Time',
            'Date',
        ];
    }

    /**
     * Validates if a date is in the specified format (default: Y-m-d)
     */
    private function isValidDateFormat($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
