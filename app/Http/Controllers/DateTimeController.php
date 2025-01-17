<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class DateTimeController extends Controller
{
    public function getCurrentTime(): JsonResponse
    {
        return response()->json([
            'current_time' => now()->setTimezone('Asia/Kolkata')->toDateTimeString()
        ]);
    }
}
