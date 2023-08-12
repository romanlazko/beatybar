<?php 

namespace App\Bots\brno_beauty_bar_bot\Commands\UserCommands;

use App\Bots\brno_beauty_bar_bot\Models\Appointment;
use App\Bots\brno_beauty_bar_bot\Models\Client;
use Carbon\Carbon;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Config;
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

        $schedule_date = Carbon::parse($appointment->schedule->date->format('Y-m-d')." ".$appointment->schedule->term);
 
        if (now() >= $schedule_date->subHours(24)) {

            $buttons = BotApi::inlineKeyboard([
                [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
            ]);

            $text = implode("\n", [
                "❗️*До твоей записи осталось менее чем 24 часа*❗️"."\n",
                "Для изменения записи, пожалуйста, свяжись с [администратором](https://t.me/valeri_kim95)."
            ]);

            return BotApi::returnInline([
                'text'          =>  $text,
                'chat_id'       =>  $updates->getChat()->getId(),
                'reply_markup'  =>  $buttons,
                'parse_mode'    =>  'Markdown',
                'message_id'    =>  $updates->getCallbackQuery()?->getMessage()->getMessageId(),
                'disable_web_page_preview' => true,
            ]);
        }

        $buttons = BotApi::inlineKeyboard([
            [array("Да", CancelCommand::$command, '')],
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        $text = "Ты уверена что хочешь отменить запись?";

        return BotApi::returnInline([
            'text'          =>  $text,
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()->getMessageId(),
        ]);
    }
}