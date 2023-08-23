<?php

namespace App\Bots\VBBeautyBot\Http\Controllers;

use App\Bots\VBBeautyBot\Services\CalendarService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(CalendarService $calendarService)
    {
        $calendar = $calendarService->generateCalendar(Carbon::parse(old('month', request()->month)) ?? now(), 7);

		return view('VBBeautyBot::calendar.index', compact('calendar'));
    }
}
