<?php 

namespace App\Bots\brno_beauty_bar_bot\Commands\UserCommands\Appointment;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\Appointment\AppointmentCommand;
use App\Bots\brno_beauty_bar_bot\Models\Schedule;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class ConfirmAppointCommand extends Command
{
    public static $command = 'confirm_appoint';

    public static $title = [
        'ru' => '✅ Подтвердить запись',
        'en' => '✅ Confirm appoint'
    ];

    public static $usage = ['confirm_appoint'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $schedule = Schedule::find($updates->getInlineData()->getScheduleId());

        if (!$schedule) {
            BotApi::answerCallbackQuery([
                'callback_query_id' => $updates->getCallbackQuery()->getId(),
                'text'              => "Этой записи уже не существует, начни с начала",
                'show_alert'        => true
            ]);

            return $this->bot->executeCommand(AppointmentCommand::$command);
        }

        if ($schedule?->appointments) {
            foreach ($schedule->appointments as $appointment) {
                if ($appointment->status == 'new') {
                    BotApi::answerCallbackQuery([
                        'callback_query_id' => $updates->getCallbackQuery()->getId(),
                        'text'              => "Это место уже занято, начни с начала",
                        'show_alert'        => true
                    ]);

                    return $this->bot->executeCommand(AppointmentCommand::$command);
                }
            }
        }
    
        $buttons = BotApi::inlineKeyboard([
            [array("👌 Подтвердить", Appoint::$command, '')]
            [array("👈 Назад", ChooseTerm::$command, '')]
        ]);

        $text = implode("\n", [
            "Пожалуйста, проверь все данные, и подтверди запись:"."\n\n",
            "Мастер: *{$appointment->schedule->user->name}*"."\n",
            "Дата и время: *{$appointment->schedule->date->format('d.m(D)')}: {$appointment->schedule->term}*"."\n",
            "Имя фамилия: *{$appointment->client->first_name} {$appointment->client->last_name}*",
            "Телефон: [{$appointment->client->phone}]()"."\n\n",
            "Если все правильно, нажми на кнопку *«Подтвердить»*"
        ]);

        return BotApi::returnInline([
            'text'          =>  $text,
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ]);
    }
}