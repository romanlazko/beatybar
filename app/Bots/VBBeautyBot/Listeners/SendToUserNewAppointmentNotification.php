<?php

namespace App\Bots\VBBeautyBot\Listeners;

use App\Bots\VBBeautyBot\Commands\UserCommands\MenuCommand;
use App\Bots\VBBeautyBot\Events\NewAppointment;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Telegram;

class SendToUserNewAppointmentNotification
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

        $buttons = $this->telegram::inlineKeyboard([
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        $text = implode("\n", [
            "✅*Запись успешна*✅"."\n",

            "Мастер: *{$appointment->schedule->user->name}*",
            "Дата и время: *{$appointment->schedule->date->format('d.m(D)')}: {$appointment->schedule->term}*"."\n",

            "Если забудешь время или дату, ты всегда сможешь найти в разделе *«мои записи»*"."\n",

            "📍 [Masarykova 427/31, 602 00 Brno-střed-Brno-město](https://goo.gl/maps/u7L3p7xahrkJaa428)"."\n",

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
