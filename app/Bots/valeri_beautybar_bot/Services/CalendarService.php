<?php

namespace App\Bots\valeri_beautybar_bot\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class CalendarService
{
    public function generateCalendar(Carbon $date, int $workDays): Collection
    {
        $start = $date->copy()->firstOfMonth();
        $end = $date->copy()->lastOfMonth();
        $weekIndex = 2;

        foreach ($start->toPeriod($end) as $day) {
            $dayOfWeek = $day->format('N');

            if ($dayOfWeek !== 1 && $dayOfWeek <= $workDays && $start->format('d') === $day->format('d')) {
                for ($i = 1; $i < $dayOfWeek; $i++) {
                    $weeks[$weekIndex][$i] = $this->createEmptyDayCell();
                }
            }

            if ($dayOfWeek <= $workDays) {
                $weeks[$weekIndex][$dayOfWeek] = $this->createDayCell($day);
            }

            if ($dayOfWeek < $workDays && $end->format('d') === $day->format('d')) {
                for ($i = $dayOfWeek + 1; $i <= $workDays; $i++) {
                    $weeks[$weekIndex][$i] = $this->createEmptyDayCell();
                }
            }

            if ($dayOfWeek == $workDays) {
                $weekIndex++;
            }
        }

        return collect([
            'days_of_week'  => $this->getDaysOfWeek($workDays),
            'weeks'         => $weeks,
        ]);
    }

    private function getDaysOfWeek(int $workDays): array
    {
        return array_slice([
            array('Mon', 'null', ''),
            array('Tue', 'null', ''),
            array('Wed', 'null', ''),
            array('Thu', 'null', ''),
            array('Fri', 'null', ''),
            array('Sat', 'null', ''),
            array('Sun', 'null', '')
        ], 0, $workDays);
    }

    private function createEmptyDayCell(): array
    {
        return array(' ', 'null', '');
    }

    private function createDayCell(Carbon $day): array
    {
        return array($day->format('d'), 'button', $day->format('Y-m-d'));
    }
}