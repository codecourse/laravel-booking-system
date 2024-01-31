<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingEmployeeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SlotController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Carbon::setTestNow(now()->addDay()->setTimeFromTimeString('09:00:00'));

Route::get('/', BookingController::class)->name('bookings');
Route::get('/bookings/{employee:slug}', BookingEmployeeController::class)->name('bookings.employee');
Route::get('/checkout/{employee:slug}/{service:slug}', CheckoutController::class)->name('checkout');

Route::get('/slots/{employee:slug}/{service:slug}', SlotController::class)->name('slots');
