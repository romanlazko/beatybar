<?php

namespace App\Bots\valeri_beautybar_bot\Listeners;

use App\Bots\valeri_beautybar_bot\Commands\UserCommands\Appointment\AppointmentCommand;
use App\Bots\valeri_beautybar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\valeri_beautybar_bot\Events\CancelAppointmentEvent;
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
    public function handle(CancelAppointmentEvent $event): void
    {
        $appointment = $event->appointment;

        $buttons = $this->telegram::inlineKeyboard([
            [array("Записаться на другую дату", AppointmentCommand::$command, '')],
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        $text = implode("\n", [
            "❌*Запись отменена*❌"."\n",

            "Мастер: *{$appointment->schedule->user->name}*",
            "Дата и время: *{$appointment->schedule->date->format('d.m(D)')}: {$appointment->schedule->term}*"
        ]);

        $this->telegram::sendMessage([
            'text'          =>  $text,
            'chat_id'       =>  $appointment->client?->telegram_chat?->chat_id,
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
        ]);
    }
}
