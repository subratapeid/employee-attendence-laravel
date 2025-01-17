<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DutyStatus;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DutyStatusController extends Controller
{
    // Store or update duty status
    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|string',
            'type' => 'required|in:on,off',
        ]);

        $userId = auth()->id();
        $type = $validatedData['type'];
        $currentDate = now()->toDateString();

        // Decode and save the photo
        $photoUrl = $this->savePhoto($validatedData['photo'], $userId, $type);

        if ($type === 'on') {
            // Start a new duty record
            DutyStatus::create([
                'user_id' => $userId,
                'start_latitude' => $validatedData['latitude'],
                'start_longitude' => $validatedData['longitude'],
                'start_photo' => $photoUrl,
                'created_at' => now(),
            ]);
        } elseif ($type === 'off') {
            // End today's duty record
            $dutyStatus = DutyStatus::where('user_id', $userId)
                ->whereDate('created_at', $currentDate)
                ->whereNull('end_latitude')
                ->whereNull('end_longitude')
                ->whereNull('end_photo')
                ->first();

            if ($dutyStatus) {
                $dutyStatus->update([
                    'end_latitude' => $validatedData['latitude'],
                    'end_longitude' => $validatedData['longitude'],
                    'end_photo' => $photoUrl,
                    'end_time' => now(),
                    'end_channel' => 'system',
                    'updated_at' => now(),
                ]);
            } else {
                return response()->json(['message' => 'No open duty record found to update.'], 404);
            }
        }

        return response()->json(['message' => 'Duty status updated successfully.']);
    }

    // store unresolved duty send manualy by user
    public function resolveUnresolvedDuty(Request $request)
    {
        // Validate the manual logout time
        $validatedData = $request->validate([
            'manual_logout_time' => 'required|date_format:h:i A', // Validate time in 12-hour am/pm format
        ]);

        $userId = auth()->id();
        $currentDate = now()->toDateString();

        // Check for unresolved duty from previous days
        $unresolvedDuty = DutyStatus::where('user_id', $userId)
            ->whereNull('end_latitude')
            ->whereNull('end_longitude')
            ->whereNull('end_photo')
            ->whereNull('end_time')
            ->whereDate('created_at', '<', $currentDate)
            ->first();

        if (!$unresolvedDuty) {
            return response()->json(['message' => 'No unresolved duty found.'], 404);
        }

        // Combine the `created_at` date with the provided am/pm time
        $manualLogoutDateTime = Carbon::createFromFormat(
            'Y-m-d h:i A',
            $unresolvedDuty->created_at->toDateString() . ' ' . $validatedData['manual_logout_time']
        );

        // Validate the logout time
        if ($manualLogoutDateTime < $unresolvedDuty->created_at) {
            return response()->json([
                'message' => 'Logout time cannot be earlier than the duty start time.',
            ], 422);
        }

        if ($manualLogoutDateTime >= now()) {
            return response()->json([
                'message' => 'Logout time cannot be in the future.',
            ], 422);
        }

        // Update the unresolved duty with the logout time
        $unresolvedDuty->update([
            'end_time' => $manualLogoutDateTime, // Save as timestamp in 24-hour format
            'end_channel' => 'manual',
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Unresolved duty resolved successfully.']);
    }


    // Check the current duty status
    public function getStatus()
    {
        $userId = auth()->id();

        // Check if there is any unresolved duty from a previous day
        $unresolvedDuty = DutyStatus::where('user_id', $userId)
            ->whereNull('end_latitude')
            ->whereNull('end_longitude')
            ->whereNull('end_photo')
            ->whereNull('end_time') // Ensure end_time is not set
            ->whereDate('created_at', '<', now()->toDateString()) // From a previous day
            ->first();

        if ($unresolvedDuty) {
            // If unresolved duty exists, notify the user
            return response()->json([
                'type' => 'unresolved',
                'message' => 'You have an unresolved duty from a previous day. Please log out before starting a new duty.',
                'unresolved_duty' => [
                    'created_at' => $unresolvedDuty->created_at->toDateTimeString(),
                    'start_latitude' => $unresolvedDuty->start_latitude,
                    'start_longitude' => $unresolvedDuty->start_longitude,
                    'start_photo' => $unresolvedDuty->start_photo,
                ],
            ]);
        }

        // Check if there is any active duty for today
        $onDutyStatus = DutyStatus::where('user_id', $userId)
            ->whereDate('created_at', now()->toDateString())
            ->whereNull('end_latitude')
            ->whereNull('end_longitude')
            ->whereNull('end_photo')
            ->first();

        if ($onDutyStatus) {
            // User is currently on duty
            return response()->json([
                'type' => 'on',
                'message' => 'You are currently on duty.',
                'start_time' => $onDutyStatus->created_at->toDateTimeString(),
            ]);
        }

        // User is off duty
        return response()->json([
            'type' => 'off',
            'message' => 'You are currently off duty.',
        ]);
    }


    // Helper function to save photos
    private function savePhoto($base64Photo, $userId, $type)
    {
        $photoData = base64_decode($base64Photo);
        $timestamp = now()->format('Y-m-d_H-i-s');
        $fileName = "user{$userId}-{$type}-{$timestamp}.jpg";
        $filePath = "photos/{$fileName}";

        // Store the photo and return its URL
        Storage::disk('public')->put($filePath, $photoData);
        return Storage::url($filePath);
    }
}
