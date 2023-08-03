<?php

namespace App\Bots\brno_beauty_bar_bot\Http\Controllers;

use App\Bots\brno_beauty_bar_bot\Http\Requests\ScheduleStoreRequest;
use App\Bots\brno_beauty_bar_bot\Models\Appointment;
use App\Bots\brno_beauty_bar_bot\Models\Employee;
use App\Bots\brno_beauty_bar_bot\Models\Schedule;
use App\Bots\brno_beauty_bar_bot\Services\CalendarService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        $user = auth()->user(); 

        $user_id = $user->isAdmin() ? request('user', $user->id) : $user->id;

        $schedules = Schedule::with('appointments')
            ->where('user_id', $user_id)
            ->get();

        $events = [];

        foreach ($schedules as $schedule) {
            if (!$schedule->appointments->isEmpty()) {
                $hasDoneAppointment = false;

                foreach ($schedule->appointments as $appointment) {

                    if (!$hasDoneAppointment && $appointment->status !== 'new') {
                        $events[] = [
                            'id' => $appointment->schedule->id,
                            'start' => $appointment->schedule->date->format('Y-m-d') . " " . $appointment->schedule->term,
                            'color' => 'gray',
                            'classNames' => "text-[6px] sm:text-sm",
                        ];
                        $hasDoneAppointment = true;
                    }

                    $statusColorMap = [
                        'new' => 'default',
                        'done' => 'green',
                        'no_done' => 'red',
                    ];

                    $color = isset($statusColorMap[$appointment->status]) ? $statusColorMap[$appointment->status] : 'gray';

                    $events[] = [
                        'id' => $appointment->id,
                        'start' => $appointment->schedule->date->format('Y-m-d') . " " . $appointment->schedule->term,
                        'color' => $color,
                        'classNames' => "text-[6px] sm:text-sm",
                        'title' => "{$appointment->client?->first_name} {$appointment->client?->last_name}",
                        'url' => route('brno_beauty_bar_bot.appointment.index', ['date' => $appointment->schedule->date->format('Y-m-d'), 'user' => $appointment->schedule->user_id]),
                    ];
                }
            }
            else {
                $events[] = [
                    'id' => $schedule->id,
                    'start' => $schedule->date->format('Y-m-d') . " " . $schedule->term,
                    'color' => 'gray',
                    'classNames' => "text-[6px] sm:text-sm",
                ];
            }
        }

		return view('brno_beauty_bar_bot::schedule.index', compact(
            'events'
        ));
    }

    public function store(ScheduleStoreRequest $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date ?? $request->start_date);

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            Schedule::updateOrCreate([
                'user_id' => $request->user,
                'date' => $currentDate->format('Y-m-d'),
                'term' => $request->term,
            ]);
            $currentDate->addDay();
        }

        return back();
    }

    public function update(Schedule $schedule, Request $request)
    {
        $schedule->update([
            'term' => $request->term,
        ]);

        return back();
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return back();
    }
}
