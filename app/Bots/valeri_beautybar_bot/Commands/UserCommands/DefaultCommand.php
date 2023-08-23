<?php 

namespace App\Bots\valeri_beautybar_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class DefaultCommand extends Command
{
    public static $command = '/default';

    public static $usage = ['/default', 'default'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $buttons = BotApi::inlineKeyboard([
            [array(MenuCommand::getTitle(), MenuCommand::$command, '')],
        ]);

        $text = implode("\n", [
            "Я не понимаю эту команду, пожалуйста пользуйся кнопками или командами из меню."."\n",
            "/menu - 🏠 Главное меню.",
        ]);

        $data = [
            'text'          =>  $text,
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()->getMessageId(),
        ];

        return BotApi::returnInline($data);
    }
}