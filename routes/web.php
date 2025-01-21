<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DutyStatusController;
use App\Http\Controllers\DateTimeController;
use App\Http\Controllers\UserImportController;


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
Route::get('/dashboard/data', [DashboardController::class, 'getDashboardData']);
Route::get('/attendance/hours', [DashboardController::class, 'getTotalWorkingHours']);
Route::get('/attendance/count', [DashboardController::class, 'getAttendanceCount']);
Route::get('/attendance/leave', [DashboardController::class, 'getTotalLeaves']);
Route::get('/attendance/late-arrival', [DashboardController::class, 'getLateArrivals']);
Route::get('/attendance/early-left', [DashboardController::class, 'getEarlyDepartures']);
Route::get('/attendance/overtime', [DashboardController::class, 'getOvertime']);


// get leave Data for Calenders
Route::get('/attendance/data', [CalenderController::class, 'getCalendarData']);

Route::get('/activity', [ActivityController::class, 'getDuties'])->name('duties.get');
Route::get('/activity/available-options', [ActivityController::class, 'getAvailableOptions']);

// Create User
Route::get('/user-import', [UserImportController::class, 'index'])->name('user.import');
Route::post('/user-import', [UserImportController::class, 'importUsers'])->name('user.import.store');
Route::get('/user-import/progress', [UserImportController::class, 'getProgress'])->name('user.import.progress');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
