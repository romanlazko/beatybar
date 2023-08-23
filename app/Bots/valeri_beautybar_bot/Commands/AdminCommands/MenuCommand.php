<?php 

namespace App\Bots\valeri_beautybar_bot\Commands\AdminCommands;

use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class MenuCommand extends Command
{
    public static $command = '/menu';

    public static $title = [
        'ru' => '🏠 Главное меню',
        'en' => '🏠 Menu'
    ];

    public static $usage = ['/menu', 'menu', 'Главное меню', 'Menu'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $text = implode("\n", [
            "*Главное меню*"."\n",
            "Ссылка для регистрации в системе для админа: [ссылка](" . url('/register?telegram_chat_id='.$updates->getChat()->getId()).")"."\n",
            "Реферальная ссылка: [ссылка](https://t.me/{$this->bot->getBotChat()->getUsername()}?start=referal={$updates->getChat()->getId()})"."\n",
        ]);

        return BotApi::returnInline([
            'text'          => $text,
            'chat_id'       => $updates->getChat()->getId(),
            'message_id'    => $updates->getCallbackQuery()?->getMessage()->getMessageId(),
            'parse_mode'    => 'Markdown'
        ]);
    }
}