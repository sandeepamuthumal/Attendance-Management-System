<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin-dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/teacher-dashboard', [DashboardController::class, 'teacherDashboard'])->name('teacher.dashboard');
});

// User Management Routes
Route::middleware(['auth', 'is.admin'])->group(function () {
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




Route::get('clear_cache', function () {
    \Artisan::call('config:cache');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    \Artisan::call('config:clear');
});
