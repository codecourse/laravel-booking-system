<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __invoke(AppointmentRequest $request)
    {
        $service = Service::find($request->service_id);

        Appointment::create(
            $request->only('employee_id', 'service_id', 'name', 'email') + [
                'starts_at' => $date = Carbon::parse($request->date)->setTimeFromTimeString($request->time),
                'ends_at' => $date->copy()->addMinutes($service->duration),
            ]
        );
    }
}
