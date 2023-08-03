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

        $buttons = $this->telegram::inlineKeyboard([
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        $text = implode("\n", [
            "🕐*Изменена дата записи*🕐"."\n",
            "*{$appointment->schedule->user->name}* -> *{$appointment->schedule->date->format('d.m(D)')}* -> *{$appointment->schedule->term}*"."\n",
            "Имя фамилия: *{$appointment->client->first_name} {$appointment->client->last_name}*",
            "Телефон: [{$appointment->client->phone}]()"."\n",
        ]);
        
        $this->telegram::sendMessage([
            'text'          =>  $text,
            'chat_id'       =>  $appointment->schedule->user->telegram_chat_id,
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
        ]);
    }
}
