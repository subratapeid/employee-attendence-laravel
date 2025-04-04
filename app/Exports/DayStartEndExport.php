<?php

namespace App\Exports;

use App\Models\DayStartEnd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DayStartEndExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return DayStartEnd::with('user') // eager load user relation
            ->get()
            ->map(function ($record) {
                return [
                    'Name'       => $record->user->name ?? '',
                    'Email'      => $record->user->email ?? '',
                    'Emp ID'     => $record->user->emp_id ?? '',
                    'Phone'      => $record->user->phone ?? '',
                    'Start Time' => $record->start_time,
                    'End Time'   => $record->end_time,
                    'Date'       => $record->created_at,
                    // add more fields as per your need
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
}
