<?php

namespace App\Bots\brno_beauty_bar_bot\Listeners;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\brno_beauty_bar_bot\Events\TomorrowAppointment;
use Romanlazko\Telegram\App\Telegram;

class SendToAdminTomorrowAppointmentNotification
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
            "⚠️У тебя на завтра запись⚠️"."\n\n",
            
            "Мастер: *{$appointment->schedule->user->name}*"."\n",
            "Дата и время: *{$appointment->schedule->date->format('d.m(D)')}: {$appointment->schedule->term}*"."\n",
            "Имя фамилия: *{$appointment->client->first_name} {$appointment->client->last_name}*",
            "Телефон: [{$appointment->client->phone}]()"
        ]);
        
        $this->telegram::sendMessage([
            'text'          =>  $text,
            'chat_id'      =>  $appointment->schedule->user->telegram_chat_id,
            'parse_mode'    =>  'Markdown',
        ]);
    }
}
