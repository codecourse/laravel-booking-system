<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __invoke()
    {
        return view('bookings.index', [
            'employees' => Employee::get(),
        ]);
    }
}
