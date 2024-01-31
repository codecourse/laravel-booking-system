<?php

namespace App\Http\Controllers;

use App\Bookings\ServiceSlotAvailability;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __invoke(AppointmentRequest $request)
    {
        $employee = Employee::find($request->employee_id);
        $service = Service::find($request->service_id);

        $availability = (new ServiceSlotAvailability(collect([$employee]), $service))
            ->forPeriod(
                Carbon::parse($request->date)->startOfDay(),
                Carbon::parse($request->date)->endOfDay(),
            );

        if (!$availability->first()->containsSlot($request->time)) {
            return response()->json([
                'error' => 'That slot was taken while you were making your booking. Please try again.'
            ], 409);
        }

        Appointment::create(
            $request->only('employee_id', 'service_id', 'name', 'email') + [
                'starts_at' => $date = Carbon::parse($request->date)->setTimeFromTimeString($request->time),
                'ends_at' => $date->copy()->addMinutes($service->duration),
            ]
        );
    }
}
