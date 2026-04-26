<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\MaintenanceController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| App Routes  (wrap in auth middleware in production)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard',    [DashboardController::class, 'index'])->name('dashboard');
Route::get('/utility',      [UtilityController::class,   'index'])->name('utility');
Route::get('/tenants',      [TenantController::class,    'index'])->name('tenants');
Route::get('/finances',     [FinanceController::class,   'index'])->name('finances');
Route::get('/maintenance',  [MaintenanceController::class,'index'])->name('maintenance');
