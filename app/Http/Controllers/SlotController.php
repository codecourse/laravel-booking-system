<?php

namespace App\Http\Controllers;

use App\Bookings\ServiceSlotAvailability;
use App\Bookings\Slot;
use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function __invoke(Employee $employee, Service $service, Request $request)
    {
        $availability = (new ServiceSlotAvailability(collect([$employee]), $service))
            ->forPeriod(
                Carbon::parse($request->date)->startOfDay(),
                Carbon::parse($request->date)->endOfDay(),
            );

        return response()->json([
            'times' => $availability->first()
                ->slots->map(fn (Slot $slot) => $slot->time->format('H:i'))
                ->values()
                ->toArray()
        ]);
    }
}
