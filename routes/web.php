<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DutyStatusController;
use App\Http\Controllers\DateTimeController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/leaves', function () {
        return view('leaves');
    })->name('leaves');

    Route::get('/activity-log', function () {
        return view('activityLog');
    })->name('activity-log');

    Route::get('/calender', function () {
        return view('calender');
    })->name('calender');
});

Route::get('/current-time', [DateTimeController::class, 'getCurrentTime']);

Route::post('/duty-status', [DutyStatusController::class, 'store']);
Route::post('/resolve-duty', [DutyStatusController::class, 'resolveUnresolvedDuty']);
Route::get('/duty-status', [DutyStatusController::class, 'getStatus']);

// get statics data
Route::get('/dashboard/data', [AttendanceController::class, 'getDashboardData']);
Route::get('/attendance/hours', [AttendanceController::class, 'getTotalWorkingHours']);
Route::get('/attendance/count', [AttendanceController::class, 'getAttendanceCount']);
Route::get('/attendance/leave', [AttendanceController::class, 'getTotalLeaves']);
Route::get('/attendance/late-arrival', [AttendanceController::class, 'getLateArrivals']);
Route::get('/attendance/early-left', [AttendanceController::class, 'getEarlyDepartures']);
Route::get('/attendance/overtime', [AttendanceController::class, 'getOvertime']);


// get leave Data for Calenders
Route::get('/attendance/data', [LeavesController::class, 'getCalendarData']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
