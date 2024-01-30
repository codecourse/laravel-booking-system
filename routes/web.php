<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
