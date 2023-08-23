<?php

namespace App\Bots\valeri_beautybar_bot\Http\Controllers;

use App\Bots\valeri_beautybar_bot\Services\CalendarService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(CalendarService $calendarService)
    {
        $calendar = $calendarService->generateCalendar(Carbon::parse(old('month', request()->month)) ?? now(), 7);

		return view('valeri_beautybar_bot::calendar.index', compact('calendar'));
    }
}
