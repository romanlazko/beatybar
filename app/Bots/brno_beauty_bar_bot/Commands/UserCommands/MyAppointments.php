<?php 

namespace App\Bots\brno_beauty_bar_bot\Commands\UserCommands;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\Appointment\Appointment as AppointmentAppointment;
use App\Bots\brno_beauty_bar_bot\Models\Appointment;
use App\Bots\brno_beauty_bar_bot\Models\Client;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class MyAppointments extends Command
{
    public static $command = 'my_appointments';

    public static $title = [
        'ru' => 'Мои записи 📌',
        'en' => 'My Appointments'
    ];

    public static $usage = ['my_appointments'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $client = Client::where('telegram_chat_id', DB::getChat($updates->getChat()->getId())->id)->first();

        $appointments = $client->appointments()
            ->where('status', 'new')
            ->whereHas('schedule', function ($query) {
                return $query->where('date', '>=', now()->format('Y-m-d'));
            })
            ->get()
            ->sortBy('schedule.date')
            ->map(function($appointment) {
                return [array("{$appointment->schedule->date->format('d.m (D)')}: {$appointment->schedule->term}", ShowMyAppointment::$command, $appointment->id)];
            });

        if ($appointments->count() == 0) {
            $text = implode("\n", [
                "Извини, у тебя нет актуальных записей еще 😢",
                "Однако ты можешь записаться к нам, тык сюда 👇🏻",
            ]);
            $buttons = BotApi::inlineKeyboard([
                [array(AppointmentAppointment::getTitle(), AppointmentAppointment::$command, '')],
                [array(MenuCommand::getTitle('ru'), MenuCommand::$command, ''),]
            ]);
        }else {
            $text = "Мои записи:";
            $buttons = BotApi::inlineKeyboard($appointments->toArray(), 'appointment_id');
        }
        
        return BotApi::returnInline([
            'text'          =>  $text,
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()->getMessageId(),
        ]);
    }
}