<?php 

namespace App\Bots\brno_beauty_bar_bot\Commands\UserCommands\Appointment;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\brno_beauty_bar_bot\Events\NewAppointment;
use App\Bots\brno_beauty_bar_bot\Models\Appointment;
use App\Bots\brno_beauty_bar_bot\Models\Profile;
use App\Bots\brno_beauty_bar_bot\Models\Schedule;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Commands\DefaultCommands\EmptyResponseCommand;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Appoint extends Command
{
    public static $command = 'appoint';

    public static $title = [
        'ru' => 'Записаться на маникюрчик',
        'en' => 'Appoint '
    ];

    public static $usage = ['appoint'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $schedule = Schedule::find($updates->getInlineData()->getScheduleId());

        if (!$schedule) {
            return BotApi::answerCallbackQuery([
                'callback_query_id' => $updates->getCallbackQuery()->getId(),
                'text'              => "Этой записи уже не существует, бомжиха",
                'show_alert'        => true
            ]);
        }

        if ($schedule?->appointments) {
            foreach ($schedule->appointments as $appointment) {
                if ($appointment->status == 'new') {
                    return BotApi::answerCallbackQuery([
                        'callback_query_id' => $updates->getCallbackQuery()->getId(),
                        'text'              => "Это место уже занято, шмара",
                        'show_alert'        => true
                    ]);
                }
            }
        }

        $appointment = Appointment::create([
            'client_id' => $updates->getInlineData()->getClientId(),
            'schedule_id' => $updates->getInlineData()->getScheduleId(),
            'status' => 'new'
        ]);

        if ($appointment) {
            event(new NewAppointment($appointment));
        }
    
        return BotApi::deleteMessage([
            'chat_id'       =>  $updates->getChat()->getId(),
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ]);
    }
}