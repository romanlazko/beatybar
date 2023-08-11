<?php 

namespace App\Bots\brno_beauty_bar_bot\Commands\UserCommands\Appointment;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\brno_beauty_bar_bot\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class ChooseWeek extends Command
{
    public static $command = 'choose_week';

    public static $usage = ['choose_week'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $schedules = Schedule::where('date', '>', now()->format('Y-m-d'))
            ->unoccupied()
            ->where('user_id', $updates->getInlineData()->getMasterId())
            ->get()
            ->sortBy('date')
            ->groupBy(function ($schedule) {
                return $schedule->date->format('W-Y');
            })
            ->map(function ($weekSchedules, $weekKey) {
                $weekStart = $weekSchedules->first()->date->startOfWeek();
                $weekEnd = $weekSchedules->last()->date->endOfWeek();
            
                return [[$weekStart->format('d.m') . " - " . $weekEnd->format('d.m'), ChooseDay::$command, $weekKey]];
            })
            ->toArray();

        $buttons = BotApi::inlineKeyboard([
            ...$schedules,
            [array("👈 Назад", MenuCommand::$command, '')]
        ], 'week');

        return BotApi::returnInline([
            'text'          =>  "*Выбери неделю:*",
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ]);
    }
}
