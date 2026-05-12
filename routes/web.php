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
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| App Routes  (wrap in auth middleware in production)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard',    [DashboardController::class, 'index'])->name('dashboard');
Route::get('/utility',      [UtilityController::class,   'index'])->name('utility');
Route::get('/tenants', [TenantController::class, 'index'])->name('tenants');
Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
Route::get('/tenants/{id}', [TenantController::class, 'show'])->name('tenants.show');
Route::get('/tenants/{id}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
Route::put('/tenants/{id}', [TenantController::class, 'update'])->name('tenants.update');
Route::delete('/tenants/{id}', [TenantController::class, 'destroy'])->name('tenants.destroy');
Route::get('/finances',     [FinanceController::class,   'index'])->name('finances');
Route::get('/finances/create', [FinanceController::class, 'create'])->name('finances.create');
Route::post('/finances', [FinanceController::class, 'store'])->name('finances.store');
Route::post('/finances/{id}/mark-paid', [FinanceController::class, 'markAsPaid'])->name('finances.mark-paid');
Route::post('/finances/{id}/mark-overdue', [FinanceController::class, 'markAsOverdue'])->name('finances.mark-overdue');
Route::post('/finances/{id}/notify', [FinanceController::class, 'notifyTenant'])->name('finances.notify');
Route::delete('/finances/{id}', [FinanceController::class, 'destroy'])->name('finances.destroy');
Route::get('/maintenance',  [MaintenanceController::class,'index'])->name('maintenance');
Route::post('/maintenance', [MaintenanceController::class,'store'])->name('maintenance.store');
Route::post('/maintenance/{id}/resolve', [MaintenanceController::class,'resolve'])->name('maintenance.resolve');
Route::post('/maintenance/{id}/assign', [MaintenanceController::class,'assignTechnician'])->name('maintenance.assign');
Route::post('/maintenance/{id}/update-status', [MaintenanceController::class,'updateStatus'])->name('maintenance.updateStatus');
