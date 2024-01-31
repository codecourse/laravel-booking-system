<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingEmployeeController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

// Carbon::setTestNow(now()->setTimeFromTimeString('17:00:00'));

Route::get('/', BookingController::class)->name('bookings');
Route::get('/bookings/{employee:slug}', BookingEmployeeController::class)->name('bookings.employee');
