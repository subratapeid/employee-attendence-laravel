<?php
use App\Exports\DesignExport;
use App\Http\Controllers\DailyActivityController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransactionController;
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
use App\Http\Controllers\TestController;

use App\Http\Controllers\PermissionController;
use Maatwebsite\Excel\Facades\Excel;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('pages.summary');
    })->name('summary');

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

    // test pages
    // Route::get('/export-design', function () {
    //     return Excel::download(new DesignExport('year', null, 2025), 'attendance_january.xlsx');
    // });

    Route::get('/export-xls', [ReportsController::class, 'export'])->name('export.xls');

    Route::get('/test-user', [TestController::class, 'fetchEmployees'])->name('test-index');
    // Helper Data Routes
    Route::get('/fetch-states', [HolidayController::class, 'getStates'])->name('fetch-states');
    Route::get('/current-time', [DateTimeController::class, 'getCurrentTime'])->name('get-time');

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

    // holiday routes
    Route::get('holiday/create', [PermissionController::class, 'create'])->name('holiday.create');
    Route::post('holiday/store', [PermissionController::class, 'store'])->name('holiday.store');
    Route::get('holidays', [PermissionController::class, 'index'])->name('holiday.index');
    Route::get('holiday/edit/{id}', [PermissionController::class, 'edit'])->name('holiday.edit');
    Route::post('holiday/update/{id}', [PermissionController::class, 'update'])->name('holiday.update');
    // permission routes
    Route::get('permission/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('permission/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('permission/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('permission/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('permission/delete', [PermissionController::class, 'destroy'])->name('permissions.delete');
    // roles routes
    Route::get('role/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('role/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('role/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('role/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('role/delete', [RoleController::class, 'destroy'])->name('roles.delete');
    // Users Routes
    Route::get('/users-data', [UserController::class, 'index'])->name('users.fetch');
    Route::get('/users', function () {
        return view('users.index');
    })->name('users.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/user/delete', [UserController::class, 'destroy'])->name('users.delete');
    // Holiday Routes
    Route::get('/holidays', [HolidayController::class, 'index'])->name('holiday.index');
    Route::get('/holiday/create', [HolidayController::class, 'create'])->name('holiday.create');
    Route::post('/holidays/store', [HolidayController::class, 'store'])->name('holiday.store');
    Route::get('/holidays/edit/{id}', [HolidayController::class, 'edit'])->name('holiday.edit');
    Route::post('/holidays/update/{id}', [HolidayController::class, 'update'])->name('holiday.update');
    Route::delete('/holidays/delete', [HolidayController::class, 'destroy'])->name('holiday.delete');

    // Transaction Routes
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/fetch', [TransactionController::class, 'fetch'])->name('transactions.fetch');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Route to apply leave
    Route::post('/apply-leave', [LeaveController::class, 'applyLeave'])->name('apply.leave');
    Route::get('/leaves/fetch', [LeaveController::class, 'index'])->name('leaves.fetch');
    Route::get('/leaves', function () {
        return view('leaves');
    })->name('leaves');
});

require __DIR__ . '/auth.php';
