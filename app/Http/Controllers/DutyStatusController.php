<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DutyStatus;
use Illuminate\Support\Facades\Storage;

class DutyStatusController extends Controller
{
    // Store or update duty status
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|string',
            'type' => 'required|in:on,off',
            'datetime' => 'required|date',
        ]);

        // Decode the base64 photo
        $photoData = base64_decode($validatedData['photo']);

        // Generate file name and path
        $userId = auth()->id();
        $timestamp = now()->format('Y-m-d_H-i-s');
        $type = $validatedData['type'];
        $fileName = "user{$userId}-{$type}-{$timestamp}.jpg";
        $filePath = "photos/{$fileName}";

        // Store the photo in the public disk
        Storage::disk('public')->put($filePath, $photoData);

        // Get the public URL of the photo
        $photoUrl = Storage::url($filePath);

        // Check if a record already exists for this user
        $dutyStatus = DutyStatus::where('user_id', $userId)->first();

        if ($dutyStatus) {
            // Update the existing record
            $dutyStatus->update([
                'latitude' => $validatedData['latitude'],
                'longitude' => $validatedData['longitude'],
                'photo' => $photoUrl,
                'type' => $validatedData['type'],
                'updated_at' => now(),
            ]);
        } else {
            // Create a new record
            DutyStatus::create([
                'user_id' => $userId,
                'latitude' => $validatedData['latitude'],
                'longitude' => $validatedData['longitude'],
                'photo' => $photoUrl,
                'type' => $validatedData['type'],
                'created_at' => now(),
            ]);
        }

        return response()->json(['message' => 'Duty status updated successfully.']);
    }

    // Get the current duty status
    public function getStatus()
    {
        $dutyStatus = DutyStatus::where('user_id', auth()->id())->first();

        if ($dutyStatus) {
            return response()->json(['type' => $dutyStatus->type]);
        }

        return response()->json(['type' => 'off']);
    }
}