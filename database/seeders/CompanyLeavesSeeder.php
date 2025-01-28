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
            // January
            [
                'leave_date' => Carbon::parse('2025-01-01'),
                'state' => 'All States',
                'reason' => 'New Year',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_date' => Carbon::parse('2025-01-14'),
                'state' => 'Gujarat',
                'reason' => 'Makar Sankranti',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_date' => Carbon::parse('2025-01-14'),
                'state' => 'Tamil Nadu',
                'reason' => 'Pongal',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_date' => Carbon::parse('2025-01-26'),
                'state' => 'All States',
                'reason' => 'Republic Day',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // March
            [
                'leave_date' => Carbon::parse('2025-03-17'),
                'state' => 'All States',
                'reason' => 'Holi',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_date' => Carbon::parse('2025-03-21'),
                'state' => 'All States',
                'reason' => 'Ram Navami',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // April
            [
                'leave_date' => Carbon::parse('2025-04-10'),
                'state' => 'All States',
                'reason' => 'Good Friday',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_date' => Carbon::parse('2025-04-14'),
                'state' => 'All States',
                'reason' => 'Dr. Ambedkar Jayanti',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // May
            [
                'leave_date' => Carbon::parse('2025-05-01'),
                'state' => 'Maharashtra, Gujarat',
                'reason' => 'Maharashtra Day / Gujarat Day',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_date' => Carbon::parse('2025-05-14'),
                'state' => 'All States',
                'reason' => 'Eid-ul-Fitr',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // August
            [
                'leave_date' => Carbon::parse('2025-08-15'),
                'state' => 'All States',
                'reason' => 'Independence Day',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_date' => Carbon::parse('2025-08-19'),
                'state' => 'Kerala',
                'reason' => 'Onam',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // October
            [
                'leave_date' => Carbon::parse('2025-10-02'),
                'state' => 'All States',
                'reason' => 'Gandhi Jayanti',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_date' => Carbon::parse('2025-10-22'),
                'state' => 'West Bengal',
                'reason' => 'Durga Puja',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // November
            [
                'leave_date' => Carbon::parse('2025-11-01'),
                'state' => 'Karnataka',
                'reason' => 'Karnataka Rajyotsava',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_date' => Carbon::parse('2025-11-09'),
                'state' => 'All States',
                'reason' => 'Diwali',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // December
            [
                'leave_date' => Carbon::parse('2025-12-25'),
                'state' => 'All States',
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
