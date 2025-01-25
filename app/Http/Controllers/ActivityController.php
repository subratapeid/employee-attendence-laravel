<?php

namespace App\Http\Controllers;

use App\Models\DutyStatus;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ActivityController extends Controller
{
    // public function getDuties(Request $request)
    // {
    //     // Get current month and year if not provided
    //     $month = $request->get('month', now()->month);
    //     $year = $request->get('year', now()->year);

    //     // Fetch the fixed office location
    //     $office = Office::first(); // Assuming there's only one office

    //     // Fetch duties
    //     $duties = DutyStatus::whereYear('created_at', $year)
    //         ->whereMonth('created_at', $month)
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     // Format data
    //     $formattedDuties = $duties->map(function ($duty) use ($office) {
    //         $startTime = $duty->created_at;
    //         $endTime = $duty->end_time;
    //         $duration = $endTime ? $startTime->diff($endTime) : $startTime->diff(now());

    //         return [
    //             'start_photo' => asset("{$duty->start_photo}"),
    //             'end_photo' => $duty->end_photo ? asset("{$duty->end_photo}") : null,
    //             'start_timestamp' => $startTime->format('d-m-Y h:i A'),
    //             'end_timestamp' => $endTime ? $endTime->format('d-m-Y h:i A') : 'Currently On Duty',
    //             'start_location' => $duty->start_location ? $duty->start_location : 'Unknown',
    //             'start_disparity' => $this->calculateDisparity(
    //                 $duty->start_latitude,
    //                 $duty->start_longitude,
    //                 $office->latitude,
    //                 $office->longitude
    //             ),
    //             'end_location' => $duty->end_location ? $duty->end_location : 'Unknown',
    //             'end_disparity' => $this->calculateDisparity(
    //                 $duty->end_latitude,
    //                 $duty->end_longitude,
    //                 $office->latitude,
    //                 $office->longitude
    //             ),
    //             'duration' => $duration ? sprintf('%d Hrs, %d Min', $duration->h, $duration->i) : 'N/A',
    //         ];
    //     });

    //     return response()->json($formattedDuties);
    // }



    public function getDuties(Request $request)
    {
        // Get current month and year if not provided
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        // Get authenticated user
        $user = auth()->user();

        // Fetch duties
        $duties = DutyStatus::where('user_id', $user->id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->get();

        // Format data
        $formattedDuties = $duties->map(function ($duty) use ($user) {
            $startTime = $duty->created_at;
            $endTime = $duty->end_time;
            $duration = $endTime ? $startTime->diff($endTime) : $startTime->diff(now());

            // Handle null latitude and longitude for user
            $userLatitude = $user->latitude ?? null;
            $userLongitude = $user->longitude ?? null;

            return [
                'start_photo' => asset("{$duty->start_photo}"),
                'end_photo' => $duty->end_photo ? asset("{$duty->end_photo}") : null,
                'start_timestamp' => $startTime->format('d-m-Y h:i A'),
                'end_timestamp' => $endTime ? $endTime->format('d-m-Y h:i A') : 'Currently On Duty',
                'start_location' => $duty->start_location ? $duty->start_location : 'Unknown',
                'start_disparity' => $this->calculateDisparity(
                    $duty->start_latitude,
                    $duty->start_longitude,
                    $userLatitude,
                    $userLongitude
                ),
                'end_location' => $duty->end_location ? $duty->end_location : 'Unknown',
                'end_disparity' => $this->calculateDisparity(
                    $duty->end_latitude,
                    $duty->end_longitude,
                    $userLatitude,
                    $userLongitude
                ),
                'duration' => $duration ? sprintf('%d Hrs, %d Min', $duration->h, $duration->i) : 'N/A',
            ];
        });

        return response()->json($formattedDuties);
    }

    // private function getLocation($latitude, $longitude)
    // {
    //     if (!$latitude || !$longitude) {
    //         return 'Unknown';
    //     }

    //     // Check if the location is already cached
    //     $cacheKey = "location_{$latitude}_{$longitude}";
    //     $cachedLocation = Cache::get($cacheKey);

    //     if ($cachedLocation) {
    //         return $cachedLocation;
    //     }

    //     // Fetch location from OpenCage API
    //     $apiKey = '1c26876625af485dbcdb8f8200f31ba7'; // Replace with your actual API key
    //     $url = sprintf(
    //         'https://api.opencagedata.com/geocode/v1/json?q=%.6f,%.6f&key=%s',
    //         $latitude,
    //         $longitude,
    //         $apiKey
    //     );

    //     $response = file_get_contents($url);

    //     if ($response) {
    //         $data = json_decode($response, true);

    //         if (!empty($data['results'][0]['formatted'])) {
    //             $location = $data['results'][0]['formatted'];

    //             // Remove unwanted parts
    //             $location = $this->sanitizeLocation($location);

    //             // Cache the location for 30 days
    //             Cache::put($cacheKey, $location, now()->addDays(30));

    //             return $location;
    //         }
    //     }

    //     return 'Location not found';
    // }



    // private function sanitizeLocation($location)
    // {
    //     // Remove "Unnamed Road"
    //     $location = preg_replace('/Unnamed Road,? ?/i', '', $location);

    //     // Remove everything after the first occurrence of a hyphen
    //     $location = preg_replace('/-\s?.*/', '', $location);

    //     // Trim any trailing commas or whitespace
    //     return trim($location, ', ');
    // }

    private function calculateDisparity($startLat, $startLng, $officeLat, $officeLng)
    {
        if (!$startLat || !$startLng || !$officeLat || !$officeLng) {
            return 'Unknown';
        }

        // Convert degrees to radians
        $earthRadius = 6371; // Earth's radius in kilometers
        $dLat = deg2rad($officeLat - $startLat);
        $dLng = deg2rad($officeLng - $startLng);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($startLat)) * cos(deg2rad($officeLat)) *
            sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c; // Distance in kilometers
        $allowedDistance = env('OFFICE_RADIUS_KM', 0.5);
        // Check if distance is within 1 km
        if ($distance <= $allowedDistance) {
            return 'Office Area';
        } else {
            return 'Outside Office';
        }
    }


    public function getAvailableOptions()
    {
        $years = DutyStatus::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        $months = DutyStatus::selectRaw('MONTH(created_at) as month')
            ->distinct()
            ->orderBy('month')
            ->pluck('month')
            ->toArray();

        // Define month labels
        $monthLabels = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        // Map month numbers to month labels
        $formattedMonths = array_map(function ($month) use ($monthLabels) {
            return ['value' => $month, 'label' => $monthLabels[$month]];
        }, $months);

        // Return the response in JSON format
        return response()->json([
            'months' => $formattedMonths,
            'years' => $years
        ]);

    }
}
