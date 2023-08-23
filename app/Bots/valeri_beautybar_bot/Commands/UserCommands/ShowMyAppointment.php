<?php 

namespace App\Bots\valeri_beautybar_bot\Commands\UserCommands;

use App\Bots\valeri_beautybar_bot\Models\Appointment;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class ShowMyAppointment extends Command
{
    public static $command = 'show_my_appointment';

    public static $usage = ['show_my_appointment'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $appointment = Appointment::find($updates->getInlineData()->getAppointmentId());
        
        if (!$appointment) {
            BotApi::answerCallbackQuery([
                'callback_query_id' => $updates->getCallbackQuery()->getId(),
                'text'              => "Не могу найти эту запись, давай попробуем с начала",
                'show_alert'        => true
            ]);

            return $this->bot->executeCommand(MenuCommand::$command);
        }

        $buttons = BotApi::inlineKeyboard([
            [array(CancelAppointmentCommand::getTitle(), CancelAppointmentCommand::$command, '')],
            [array(MenuCommand::getTitle(), MenuCommand::$command, '')]
        ]);

        $text = implode("\n", [
            "Мастер: *{$appointment->schedule->user->name}*",
            "Дата и время: *{$appointment->schedule->date->format('d.m(D)')}: {$appointment->schedule->term}*"."\n",

            "📍 [Masarykova 427/31, 602 00 Brno-střed-Brno-město](https://goo.gl/maps/u7L3p7xahrkJaa428)"."\n",

            "Будем тебя ждать!",
        ]);

        return BotApi::returnInline([
            'text'          =>  $text,
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()->getMessageId(),
        ]);
    }
}