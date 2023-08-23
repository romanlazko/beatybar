<?php

namespace App\Bots\valeri_beautybar_bot\Http\Controllers;

use App\Bots\valeri_beautybar_bot\Events\CancelAppointmentEvent;
use App\Bots\valeri_beautybar_bot\Events\NewAppointment;
use App\Bots\valeri_beautybar_bot\Events\UpdateAppointment;
use App\Bots\valeri_beautybar_bot\Http\Requests\AppointmentStoreRequest;
use App\Bots\valeri_beautybar_bot\Models\Appointment;
use App\Bots\valeri_beautybar_bot\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $appointments = Appointment::with('schedule')
            ->whereHas('schedule', function($query) use ($user) {
                $query->where('user_id', $user->isAdmin() ? request('user', $user->id) : $user->id)
                    ->where('date', request('date', now()->format('Y-m-d')));
            })
            ->get()
            ->sortBy('schedule.term');

        $schedules = Schedule::with('appointment')
            ->orderBy('date', 'asc')
            ->where('user_id', $user->isAdmin() ? request('user', $user->id) : $user->id)
            ->where('date', '>=', now()->format('Y-m-d'))
            ->get()
            ->filter(function ($schedule) {
                return $schedule->appointment == null;
            })
            ->groupBy(function ($schedule) {
                return $schedule->date->format('Y-m-d');
            });

        return view('valeri_beautybar_bot::appointment.index', compact('appointments', 'schedules'));
    }

    public function update(Appointment $appointment, Request $request)
    {
        $appointment->update([
            'schedule_id' => $request->schedule ?? $appointment->schedule->id,
            'price' => $request->price ?? $appointment->price,
            'status' => $request->status ?? $appointment->status,
        ]);

        if($appointment->status === 'new'){
            event(new UpdateAppointment($appointment));
        }

        if($appointment->status === 'canceled' OR $appointment->status === 'no_done'){
            event(new CancelAppointmentEvent($appointment));
        }

        return back();
    }

    public function store(AppointmentStoreRequest $request)
    {
        $schedule = Schedule::find($request->schedule);

        if ($schedule?->appointments) {
            foreach ($schedule->appointments as $appointment) {
                if ($appointment->status == 'new') {
                    return back()->with([
                        'ok' => false,
                        'description' => "This schedule is occupied"
                    ]);
                }
            }
        }

        $appointment = Appointment::create([
            'client_id' => $request->client,
            'schedule_id' => $request->schedule,
            'status' => 'new'
        ]);

        if ($appointment) {
            event(new NewAppointment($appointment));
        }

        return back()->with([
            'ok' => true,
            'description' => "Appointment succesfuly created"
        ]);
    }
}
