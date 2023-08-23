<?php 

namespace App\Bots\valeri_beautybar_bot\Commands\UserCommands\Appointment;

use App\Bots\valeri_beautybar_bot\Commands\UserCommands\Appointment\AppointmentCommand;
use App\Bots\valeri_beautybar_bot\Events\NewAppointment;
use App\Bots\valeri_beautybar_bot\Models\Appointment;
use App\Bots\valeri_beautybar_bot\Models\Schedule;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Appoint extends Command
{
    public static $command = 'appoint';

    public static $title = [
        'ru' => 'Записаться',
        'en' => 'Appoint'
    ];

    public static $usage = ['appoint'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $schedule = Schedule::find($updates->getInlineData()->getScheduleId());

        if (!$schedule) {
            BotApi::answerCallbackQuery([
                'callback_query_id' => $updates->getCallbackQuery()->getId(),
                'text'              => "Этой записи уже не существует, давай попробуем с начала",
                'show_alert'        => true
            ]);

            return $this->bot->executeCommand(AppointmentCommand::$command);
        }

        if ($schedule?->appointments) {
            foreach ($schedule->appointments as $appointment) {
                if ($appointment->status == 'new') {
                    BotApi::answerCallbackQuery([
                        'callback_query_id' => $updates->getCallbackQuery()->getId(),
                        'text'              => "Это место уже занято, давай попробуем с начала",
                        'show_alert'        => true
                    ]);

                    return $this->bot->executeCommand(AppointmentCommand::$command);
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