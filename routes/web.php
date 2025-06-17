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

//Dashboards
Route::get('/', [DashboardController::class, 'index']);
Route::get('/admin-dashboard', [DashboardController::class, 'adminDashboard']);
Route::get('/manager-dashboard', [DashboardController::class, 'managerDashboard']);

//Authentication Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/process', [AuthController::class, 'loginProcess'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//User Management
Route::controller(UserController::class)->group(function () {
    Route::get('/active-users', 'activeUsers')->name('active.users');
    Route::get('/deactive-users', 'deactiveUsers')->name('deactive.users');
    Route::get('/load/active-users', 'loadActiveUsers');
    Route::get('/load/deactive-users', 'loadDeactiveUsers');
    Route::get('/load/cities', 'loadCities');
    Route::post('/users/store', 'storeUsers');
    Route::get('/users/edit', 'editUsers');
    Route::post('/users/update', 'updateUsers');
    Route::post('/users/delete/{id}', 'updateStatus')->name('delete.user');
    Route::post('/user/reset-password', 'resetPassword');
    Route::get('/event-managers', 'eventManagers')->name('event.managers');
    Route::post('/city/store', 'storeCity');
});

Route::get('clear_cache', function () {
    \Artisan::call('config:cache');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    \Artisan::call('config:clear');
});


