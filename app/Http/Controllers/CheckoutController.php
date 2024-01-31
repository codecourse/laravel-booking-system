<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Service;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __invoke(Employee $employee, Service $service)
    {
        abort_unless($employee->services->contains($service), 404);

        // availability checks

        return view('bookings.checkout', [
            'employee' => $employee,
            'service' => $service,
        ]);
    }
}
