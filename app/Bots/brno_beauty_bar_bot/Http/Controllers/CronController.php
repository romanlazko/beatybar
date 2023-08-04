<?php

namespace App\Bots\brno_beauty_bar_bot\Http\Controllers;

use App\Bots\brno_beauty_bar_bot\Events\TomorrowAppointment;
use App\Bots\brno_beauty_bar_bot\Models\Appointment;
use App\Bots\brno_beauty_bar_bot\Services\CalendarService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CronController extends Controller
{
    public function __invoke()
    {
        $appointments = Appointment::where('status', 'new')
            ->whereHas('schedule', function($query) {
                $query->where('date', now()->addDay()->format('Y-m-d'));
            });

        foreach ($appointments as $appointment) {
            event(new TomorrowAppointment($appointment));
        }

        return true;
    }
}
