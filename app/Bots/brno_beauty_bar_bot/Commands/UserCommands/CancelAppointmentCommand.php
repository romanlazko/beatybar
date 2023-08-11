<?php 

namespace App\Bots\brno_beauty_bar_bot\Commands\UserCommands;

use App\Bots\brno_beauty_bar_bot\Models\Appointment;
use App\Bots\brno_beauty_bar_bot\Models\Client;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class CancelAppointmentCommand extends Command
{
    public static $command = 'cancel_appointment';

    public static $title = [
        'ru' => '❌ Отменить запись',
        'en' => '❌ Cancel appointment'
    ];

    public static $usage = ['cancel_appointment'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $appointment = Appointment::find($updates->getInlineData()->getAppointmentId());
        
        if (!$appointment) {
            return BotApi::answerCallbackQuery([
                'callback_query_id' => $updates->getCallbackQuery()->getId(),
                'text'              => "Не могу найти эту запись",
                'show_alert'        => true
            ]);
        }

        $buttons = BotApi::inlineKeyboard([
            [array(CancelCommand::getTitle('ru'), CancelCommand::$command, '')]
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        $text = "📎 *{$appointment->schedule->date->format('d.m (D)')}: {$appointment->schedule->term}* - у тебя маникюр в BeautyBar, не забудь 👄";

        return BotApi::returnInline([
            'text'          =>  $text,
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()->getMessageId(),
        ]);
    }
}