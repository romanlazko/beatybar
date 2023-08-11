<?php

namespace App\Bots\brno_beauty_bar_bot\Listeners;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\brno_beauty_bar_bot\Events\UpdateAppointment;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Telegram;

class SendToAdminUpdateAppointmentNotification
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
    public function handle(UpdateAppointment $event): void
    {
        $appointment = $event->appointment;

        $admin_ids = $this->telegram->getAdmins()->toArray();

        $buttons = $this->telegram::inlineKeyboard([
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        $text = implode("\n", [
            "🕐*Изменена дата записи*🕐"."\n",

            "#{$appointment->schedule->date->format('d.m(D)')}"."\n",

            "Мастер: *{$appointment->schedule->user->name}*",
            "Дата и время: *{$appointment->schedule->date->format('d.m(D)')}: {$appointment->schedule->term}*",
            "Имя фамилия: *{$appointment->client->first_name} {$appointment->client->last_name}*",
            "Телефон: [{$appointment->client->phone}]()"
        ]);
        
        $this->telegram::sendMessages([
            'text'          =>  $text,
            'chat_ids'       =>  $admin_ids,
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
        ]);
    }
}
