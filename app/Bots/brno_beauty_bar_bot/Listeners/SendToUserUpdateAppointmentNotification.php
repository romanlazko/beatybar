<?php

namespace App\Bots\brno_beauty_bar_bot\Listeners;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\brno_beauty_bar_bot\Events\UpdateAppointment;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Telegram;

class SendToUserUpdateAppointmentNotification
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
            "Дата и время записи: *{$appointment->schedule->date->format('d.m (D)')}: {$appointment->schedule->term}*"."\n",
            "Если забудешь время или дату, ты всегда сможешь найти в разделе *«мои записи»*"."\n",

            "*Где мы находимся 📍*"."\n",
            "Masarykova 427/31",
            "602 00 Brno-střed-Brno-město"."\n",

            "Будем тебя ждать!",
        ]);
        $this->telegram::sendMessage([
            'text'          =>  $text,
            'chat_id'       =>  $appointment->client->telegram_chat->chat_id,
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
        ]);
    }
}
