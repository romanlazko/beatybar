<?php 

namespace App\Bots\brno_beauty_bar_bot\Commands\UserCommands;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\Appointment\Appointment;
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
        // $buttons = BotApi::inlineKeyboard([
        //     [array(Appointment::getTitle(), Appointment::$command, '')],
        //     [array(MyAppointments::getTitle(), MyAppointments::$command, '')],
        //     [array(Location::getTitle(), Location::$command, '')],
        // ]);

        $data = [
            'text'          =>  "ghbdtn",
            'chat_id'       =>  $updates->getChat()->getId(),
            // 'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()->getMessageId(),
            'disable_web_page_preview' => true
        ];

        return BotApi::returnInline($data);
    }
}