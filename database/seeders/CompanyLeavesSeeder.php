<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CompanyLeavesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $leaves = [
            [
                'leave_date' => Carbon::parse('2025-01-01'),
                'state' => 'All',
                'reason' => 'New Year',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_date' => Carbon::parse('2025-08-15'),
                'state' => 'All',
                'reason' => 'Independence Day',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_date' => Carbon::parse('2025-10-02'),
                'state' => 'Gujarat',
                'reason' => 'Gandhi Jayanti',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_date' => Carbon::parse('2025-12-25'),
                'state' => 'Tamil Nadu',
                'reason' => 'Christmas',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data into company_leaves table
        DB::table('company_leaves')->insert($leaves);

        echo "Company leaves seeded successfully.\n";
    }
}
