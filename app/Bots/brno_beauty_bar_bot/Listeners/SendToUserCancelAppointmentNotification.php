<?php

namespace App\Bots\brno_beauty_bar_bot\Listeners;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\brno_beauty_bar_bot\Events\CancelAppointment;
use App\Bots\brno_beauty_bar_bot\Events\UpdateAppointment;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Telegram;

class SendToUserCancelAppointmentNotification
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
    public function handle(CancelAppointment $event): void
    {
        $appointment = $event->appointment;

        $buttons = $this->telegram::inlineKeyboard([
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        $text = implode("\n", [
            "❌*Ваша запись отменена*❌"."\n",
            "Дата и время записи: *{$appointment->schedule->date->format('d.m(D)')}: {$appointment->schedule->term}*",
        ]);
        $this->telegram::sendMessage([
            'text'          =>  $text,
            'chat_id'       =>  $appointment->client->telegram_chat->chat_id,
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
        ]);
    }
}
