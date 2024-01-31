<?php

use App\Http\Controllers\BookingController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Carbon::setTestNow(now()->setTimeFromTimeString('17:00:00'));

Route::get('/', BookingController::class)->name('booking');
