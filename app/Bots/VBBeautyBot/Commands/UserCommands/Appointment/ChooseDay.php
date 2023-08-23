<?php 

namespace App\Bots\VBBeautyBot\Commands\UserCommands\Appointment;

use App\Bots\VBBeautyBot\Commands\UserCommands\MenuCommand;
use App\Bots\VBBeautyBot\Models\Schedule;
use Carbon\Carbon;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class ChooseDay extends Command
{
    public static $command = 'choose_day';

    public static $usage = ['choose_day'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $weekYearFormat = $updates->getInlineData()->getWeek();

        list($weekNumber, $year) = explode('-', $weekYearFormat);

        $carbonDate = Carbon::now()->setISODate($year, $weekNumber, 1);

        $schedules = Schedule::where('date', '>=', $carbonDate->clone()->startOfWeek())
            ->unoccupied()
            ->where('date', '>', now()->startOfDay())
            ->where('date', '<=', $carbonDate->clone()->endOfWeek())
            ->where('user_id', $updates->getInlineData()->getMasterId())
            ->get()
            ->sortBy('date')
            ->groupBy(function ($schedule) {
                return $schedule->date->format('d.m.Y (D)');
            })
            ->map(function ($daySchedules, $dayKey) {
                return [array($dayKey, ChooseTerm::$command, $dayKey)];
            })
            ->toArray();

        $buttons = BotApi::inlineKeyboard([
            ...$schedules,
            [array("👈 Назад", ChooseWeek::$command, '')]
        ], 'day');

        return BotApi::returnInline([
            'text'          =>  "*Выбери день:*",
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ]);
    }
}
