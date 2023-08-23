<?php

namespace App\Bots\VBBeautyBot\Listeners;

use App\Bots\VBBeautyBot\Commands\UserCommands\MenuCommand;
use App\Bots\VBBeautyBot\Events\TomorrowAppointment;
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

        $buttons = $this->telegram::inlineKeyboardWithLink(
            array('text' => 'Контакт', 'url'  => "tg://user?id={$appointment->client?->telegram_chat?->chat_id}")
        );

        $text = implode("\n", [
            "⚠️*Напоминание о записи*⚠️"."\n",

            "#{$appointment->schedule->date->format('D')}{$appointment->schedule->date->format('dmY')}"."\n",

            "Мастер: *{$appointment->schedule->user->name}*",
            "Дата и время: *{$appointment->schedule->date->format('d.m(D)')}: {$appointment->schedule->term}*",
            "Имя фамилия: *{$appointment->client->first_name} {$appointment->client->last_name}*",
            "Телефон: [{$appointment->client->phone}]()"
        ]);
        
        $this->telegram::sendMessage([
            'text'          =>  $text,
            'chat_id'       =>  $appointment->schedule->user->telegram_chat_id,
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
        ]);
    }
}
