<?php
namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttendanceExport implements FromCollection, WithHeadings, WithTitle
{
    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        // Based on the filter, fetch the appropriate data
        $query = User::query();

        // Adjust query based on filter
        if ($this->filter == 'today') {
            $query->whereDate('created_at', now()->toDateString());
        } elseif ($this->filter == 'this_week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($this->filter == 'this_month') {
            $query->whereMonth('created_at', now()->month);
        } elseif ($this->filter == 'this_year') {
            $query->whereYear('created_at', now()->year);
        }

        // Get the attendance data
        return $query->get(['id', 'name', 'email', 'created_at']);
    }

    public function headings(): array
    {
        return ['Employee ID', 'Employee Name', 'Email', 'Attendance Date'];
    }

    public function title(): string
    {
        return 'Attendance Report';
    }
}
