<?php 

namespace App\Bots\valeri_beautybar_bot\Commands\UserCommands\Appointment;

use App\Bots\valeri_beautybar_bot\Models\Schedule;
use Carbon\Carbon;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class ChooseTerm extends Command
{
    public static $command = 'choose_term';

    public static $usage = ['choose_term'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $dayFormat = $updates->getInlineData()->getDay();
        
        $carbonDate = Carbon::createFromFormat('d.m.Y (D)', $dayFormat);

        $schedules = Schedule::where('date', '=', $carbonDate->format('Y-m-d'))
            ->unoccupied()
            ->where('user_id', $updates->getInlineData()->getMasterId())
            ->get()
            ->sortBy('term')
            ->map(function ($schedule) {
                return [array($schedule->term, ConfirmAppointCommand::$command, $schedule->id)];
            })
            ->toArray();

        $buttons = BotApi::inlineKeyboard([
            ...$schedules,
            [array("👈 Назад", ChooseDay::$command, '')]
        ], 'schedule_id');

        return BotApi::returnInline([
            'text'          =>  "*Выбери время:*",
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ]);
    }
}
