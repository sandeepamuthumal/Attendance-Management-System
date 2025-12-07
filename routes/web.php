<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect to dashboard if already logged in
Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

//Authentication Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/process', [AuthController::class, 'loginProcess'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin-dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard')->middleware('role:Admin');
    Route::get('/teacher-dashboard', [DashboardController::class, 'teacherDashboard'])->name('teacher.dashboard')->middleware('role:Teacher');
});

// User Management Routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/users/admins', [UserController::class, 'admins'])->name('admin.users.admins');
    Route::get('/admin/users/teachers', [UserController::class, 'teachers'])->name('admin.users.teachers');
    Route::get('/load/users', [UserController::class, 'loadUsers'])->name('load.users');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/deactivate/{id}', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::post('/users/activate/{id}', [UserController::class, 'activate'])->name('users.activate');
    Route::post('/users/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
});

Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    // Class Management
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/load', [ClassController::class, 'loadClasses'])->name('classes.load');
    Route::post('/classes/store', [ClassController::class, 'store'])->name('classes.store');
    Route::get('/classes/edit', [ClassController::class, 'edit'])->name('classes.edit');
    Route::post('/classes/update', [ClassController::class, 'update'])->name('classes.update');
    Route::delete('/classes/delete/{id}', [ClassController::class, 'deactivate'])->name('classes.destroy');
    Route::get('/classes/teacher-classes', [ClassController::class, 'getTeacherClasses'])->name('classes.teacher-classes');

    Route::name('admin.')->group(function () {
        // Student Management Routes
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/edit/{id}', [StudentController::class, 'edit'])->name('students.edit');
        Route::post('/students/update', [StudentController::class, 'update'])->name('students.update');

        // AJAX Routes
        Route::get('/students/load', [StudentController::class, 'loadStudents'])->name('students.load');
        Route::get('/students/search', [StudentController::class, 'search'])->name('students.search');
        Route::post('/students/delete/{id}', [StudentController::class, 'deactivate'])->name('students.destroy');
    });
});

Route::get('/students/profile/{id}', [StudentController::class, 'profile'])->name('students.profile')->middleware('permission:view students');
Route::get('/students/download-qr/{id}', [StudentController::class, 'downloadQR'])->name('students.download-qr')->middleware('permission:view students');

Route::middleware(['auth'])->group(function () {
    //Attendance Management
    Route::get('/attendance-scanner', [AttendanceController::class, 'attendanceScanner'])->name('attendance.scanner');
    Route::get('/attendance-reports', [AttendanceController::class, 'attendanceReports'])->name('attendance.reports');
    Route::get('/attendance/report/students', [AttendanceController::class, 'getStudents'])->name('attendance.report.students');

    //Class schedule management
    Route::get('/classes/schedule/load', [ClassScheduleController::class, 'loadSchedule'])->name('classes.schedule.load');
    Route::post('/classes/schedule/save', [ClassScheduleController::class, 'saveSchedule'])->name('classes.schedule.save');
});

// Teacher Routes (for viewing their classes)
Route::middleware(['auth', 'role:Teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/my-classes', [ClassController::class, 'teacherClasses'])->name('classes.index');
    Route::get('/my-students', [StudentController::class, 'teachertudents'])->name('students.index');
    Route::get('/classes/load', [ClassController::class, 'loadClasses'])->name('classes.load');
    Route::get('/students/load', [StudentController::class, 'loadStudents'])->name('students.load');
    Route::get('/students/search', [StudentController::class, 'search'])->name('students.search');
});




Route::get('clear_cache', function () {
    \Artisan::call('config:cache');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    \Artisan::call('config:clear');
});
