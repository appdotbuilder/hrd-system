<?php

use App\Http\Controllers\HrdDashboardController;
use App\Http\Controllers\HrdAttendanceController;
use App\Http\Controllers\HrdEmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HRD Routes
|--------------------------------------------------------------------------
|
| Here is where you can register HRD related routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // HRD Dashboard
    Route::get('/hrd', [HrdDashboardController::class, 'index'])->name('hrd.dashboard');
    
    // Attendance Routes
    Route::controller(HrdAttendanceController::class)->group(function () {
        Route::get('/hrd/attendance', 'index')->name('hrd.attendance.index');
        Route::post('/hrd/attendance', 'store')->name('hrd.attendance.store');
    });
    
    // Employee Management Routes
    Route::resource('hrd/employees', HrdEmployeeController::class, [
        'names' => [
            'index' => 'hrd.employees.index',
            'create' => 'hrd.employees.create',
            'store' => 'hrd.employees.store',
            'show' => 'hrd.employees.show',
            'edit' => 'hrd.employees.edit',
            'update' => 'hrd.employees.update',
            'destroy' => 'hrd.employees.destroy',
        ]
    ]);
});