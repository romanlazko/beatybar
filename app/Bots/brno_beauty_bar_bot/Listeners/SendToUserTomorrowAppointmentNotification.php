<?php

namespace App\Bots\brno_beauty_bar_bot\Listeners;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\brno_beauty_bar_bot\Events\TomorrowAppointment;
use Romanlazko\Telegram\App\Telegram;

class SendToUserTomorrowAppointmentNotification
{

    /**
     * Create the event listener.
     */
    public function __construct(private Telegram $telegram)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(TomorrowAppointment $event): void
    {
        $appointment = $event->appointment;

        $text = implode("\n", [
            "Привет, дорогая❤️"."\n",

            "Завтра, *{$appointment->schedule->date->format('d.m (D)')}* -> *{$appointment->schedule->term}* ты записана на маникюр."."\n",

            "Буду ждать тебя!"."\n",
        ]);

        if ($appointment->client->telegram_chat_id) {
            $this->telegram::sendMessage([
                'text'          =>  $text,
                'chat_id'       =>  $appointment?->client?->telegram_chat_id,
                'parse_mode'    =>  'Markdown',
            ]);
        }
    }
}
