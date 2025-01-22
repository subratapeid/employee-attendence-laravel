<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Get the data to be exported (all users' id, name, and email)
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Get all users with id, name, and email
        return User::select('id', 'name', 'email')->get();
    }

    /**
     * Define the headings for the CSV
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
        ];
    }

    /**
     * Map the data for each user in the collection
     *
     * @param mixed $user
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->id,        // User ID
            $user->name,      // User Name
            $user->email,     // User Email
        ];
    }
}
