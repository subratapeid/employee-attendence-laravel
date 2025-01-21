<?php
namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    private $failedRecords = [];

    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => bcrypt($row['password']),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ];
    }

    public function onError(\Throwable $error): void
    {
        // Capture failed record with error message
        $this->failedRecords[] = [
            'row' => $error->getMessage(),
            'message' => $error->getMessage()
        ];
    }

    public function hasErrors()
    {
        return !empty($this->failedRecords);
    }

    public function getErrors()
    {
        return $this->failedRecords;
    }

    public function exportFailedRecords()
    {
        $filePath = 'failed_imports/failed_records_' . time() . '.csv';

        $data = array_merge([['Row', 'Error Message']], $this->failedRecords);

        $csv = fopen(storage_path('app/public/' . $filePath), 'w');
        foreach ($data as $row) {
            fputcsv($csv, $row);
        }
        fclose($csv);

        return $filePath;
    }
}




// backup use


// return new User([
//     'name' => $row['name'],
//     'emp_id' => $row['emp_id'],
//     'phone' => $row['phone'],
//     'email' => $row['email'],
//     'password' => bcrypt($row['password']),
//     'state' => $row['state'],
//     'district' => $row['district'],
//     'office_name' => $row['office_name'],
// ]);

// return [
//     'name' => 'required|string|max:255',
//     'emp_id' => 'required|unique:users,emp_id',
//     'phone' => 'required|numeric|digits:10|unique:users,phone',
//     'email' => 'required|email|unique:users,email',
//     'password' => 'required|string|min:6',
//     'state' => 'required|string',
//     'district' => 'required|string',
//     'office_name' => 'required|string',
// ];

