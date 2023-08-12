<?php

namespace App\Bots\brno_beauty_bar_bot\Listeners;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\brno_beauty_bar_bot\Events\NewAppointment;
use Romanlazko\Telegram\App\Telegram;

class SendToAdminNewAppointmentNotification
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
    public function handle(NewAppointment $event): void
    {
        $appointment = $event->appointment;

        $buttons = $this->telegram::inlineKeyboardWithLink(
            array('text' => 'Контакт', 'url'  => "tg://user?id={$appointment->client?->telegram_chat?->chat_id}")
        );

        $text = implode("\n", [
            "✅*Новая запись на маникюр*✅"."\n",

            "#{$appointment->schedule->date->format('D')}{$appointment->schedule->date->format('dmY')}"."\n",

            "Мастер: *{$appointment->schedule->user->name}*",
            "Дата и время: *{$appointment->schedule->date->format('d.m(D)')}: {$appointment->schedule->term}*",
            "Имя фамилия: *{$appointment->client?->first_name} {$appointment->client?->last_name}*",
            "Телефон: [{$appointment->client?->phone}]()"
        ]);
        
        $this->telegram::sendMessage([
            'text'          =>  $text,
            'chat_id'       =>  $appointment->schedule->user->telegram_chat_id,
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
        ]);
    }
}
