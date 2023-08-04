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

        $admin_ids = $this->telegram->getAdmins()->toArray();

        $buttons = $this->telegram::inlineKeyboard([
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        $text = implode("\n", [
            "✅*Новая запись на маникюр*✅"."\n",
            "*{$appointment->schedule->user->name}* -> *{$appointment->schedule->date->format('d.m(D)')}* -> *{$appointment->schedule->term}*"."\n",
            "Имя фамилия: *{$appointment->client->first_name} {$appointment->client->last_name}*",
            "Телефон: [{$appointment->client->phone}]()"."\n",
        ]);
        
        $this->telegram::sendMessages([
            'text'          =>  $text,
            'chat_ids'      =>  $admin_ids,
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
        ]);
    }
}
