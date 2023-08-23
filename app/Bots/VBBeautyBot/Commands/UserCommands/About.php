<?php 

namespace App\Bots\VBBeautyBot\Commands\UserCommands;

use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class About extends Command
{
    public static $command = '/about';

    public static $title = [
        'ru' => 'О нас',
        'en' => 'About us'
    ];

    public static $usage = ['/about', 'about'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $buttons = BotApi::inlineKeyboard([
            [array(MenuCommand::getTitle(), MenuCommand::$command, '')]
        ]);

        $text = implode("\n", [
            "О нас:"."\n",

            "💅 Наши работы можно посмотреть [тут](https://instagram.com/valeri.beautybar?igshid=MzRlODBiNWFlZA==)"."\n",

            "📍 Мы находимся [тут](https://goo.gl/maps/m2jeHYxHRFgSrXxd9)"."\n",

            "☎️ Связь с [менеджером](https://t.me/valeri_kim95)"
        ]);

        $data = [
            'text'          =>  $text,
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()->getMessageId(),
            'disable_web_page_preview' => true
        ];

        return BotApi::returnInline($data);
    }
}