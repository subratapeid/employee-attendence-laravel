<?php
namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    protected $filter;
    protected $search;

    public function __construct($filter = null, $search = null)
    {
        $this->filter = $filter;
        $this->search = $search;
    }

    public function collection()
    {
        $query = User::query();

        if (!empty($this->filter) && !empty($this->search)) {
            if ($this->filter === 'department') {
                $query->where('department', 'LIKE', "%{$this->search}%");
            } elseif ($this->filter === 'designation') {
                $query->where('designation', 'LIKE', "%{$this->search}%");
            }
        } elseif (!empty($this->search)) {
            // Search across multiple fields if filter is not specified
            $query->where(function ($q) {
                $q->where('name', 'LIKE', "%{$this->search}%")
                    ->orWhere('email', 'LIKE', "%{$this->search}%");
                //   ->orWhere('department', 'LIKE', "%{$this->search}%")
                //   ->orWhere('designation', 'LIKE', "%{$this->search}%");
            });
        }

        return $query->select('id', 'name', 'email', 'emp_id', 'phone', 'state', 'district', 'location', 'status')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'EmpId', 'Phone', 'State', 'District', 'Location', 'Status'];
    }
}

