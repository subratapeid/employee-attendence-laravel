<?php
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ExportUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\DutyStatusController;
use App\Http\Controllers\DateTimeController;
use App\Http\Controllers\UserImportController;

use App\Http\Controllers\PermissionController;


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

    // Employees Page Data
    Route::get('/employees', [EmployeesController::class, 'index'])->name('employees.index');
    Route::get('/employee/{id}', [EmployeesController::class, 'show'])->name('employees.single');
    Route::post('/employees', [EmployeesController::class, 'store'])->name('employees.store');
    Route::delete('/employees/{id}', [EmployeesController::class, 'destroy'])->name('employees.destroy');
    Route::put('/employees/{id}', [EmployeesController::class, 'update'])->name('employees.update');
    Route::post('/employees/reset-password/{id}', [EmployeesController::class, 'resetPassword'])->name('employees.resetPassword');

    // Reports Page Data
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');

    Route::get('/reports/attendance/export', [ReportsController::class, 'exportAttendance'])->name('reports.attendance.export');
    Route::get('/reports/activity/export', [ReportsController::class, 'exportActivity'])->name('reports.activity.export');
    Route::get('/reports/late/export', [ReportsController::class, 'exportLateArrival'])->name('reports.late.export');
    Route::get('/reports/absenteeism/export', [ReportsController::class, 'exportAbsenteeism'])->name('reports.absenteeism.export');


    // Import Data
    Route::get('/user-import', [UserImportController::class, 'index'])->name('user.import');
    Route::post('/user-import', [UserImportController::class, 'importUsers'])->name('user.import.store');
    Route::get('/user-import/progress', [UserImportController::class, 'getProgress'])->name('user.import.progress');

    // export Data
    Route::get('/export-users', [ExportUserController::class, 'exportUsers'])->name('export.users');
    Route::get('/employees/export', [EmployeesController::class, 'export'])->name('employees.export');

    // Route for exporting the report
    Route::get('/export/csv', [ReportsController::class, 'exportCSV'])->name('report.export');
    // Route for fetching filtered report data (if needed)
    Route::get('/reports/filter', [ReportsController::class, 'getFilteredReport'])->name('report.filtered');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // permission routes
    Route::get('permissions-create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('permissions-create', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('permissions-edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('permissions-edit/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    // permission routes
    Route::get('roles-create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles-create', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles-edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('roles-edit/{id}', [RoleController::class, 'update'])->name('roles.update');
    // Users Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users-create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users-edit-{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users-{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users', [UserController::class, 'destroy'])->name('users.delete');


});

require __DIR__ . '/auth.php';
