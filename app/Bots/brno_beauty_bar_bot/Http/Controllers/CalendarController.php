<?php

namespace App\Bots\brno_beauty_bar_bot\Http\Controllers;

use App\Bots\brno_beauty_bar_bot\Services\CalendarService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(CalendarService $calendarService)
    {
        $calendar = $calendarService->generateCalendar(Carbon::parse(old('month', request()->month)) ?? now(), 7);

		return view('brno_beauty_bar_bot::calendar.index', compact('calendar'));
    }
}
