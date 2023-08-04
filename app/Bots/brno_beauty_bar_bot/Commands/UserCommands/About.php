<?php 

namespace App\Bots\brno_beauty_bar_bot\Commands\UserCommands;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\Appointment\Appointment;
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
            "Мы лучший салон в городе"."\n",
            "Наши работы: [тут](https://instagram.com)"."\n",
            "Администратор: [тут](https://t.me/valeri_kim95)"."\n",
            "Где мы находимся: [Masarykova 427/31](https://goo.gl/maps/m2jeHYxHRFgSrXxd9)"."\n",
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