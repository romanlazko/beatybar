<?php 

namespace App\Bots\VBBeautyBot\Commands\UserCommands;

use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Location extends Command
{
    public static $command = '/location';

    public static $title = [
        'ru' => 'Где мы находимся 📍',
        'en' => 'Where we are 📍'
    ];

    public static $usage = ['/location', 'location'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        BotApi::deleteMessage([
            'chat_id'       =>  $updates->getChat()->getId(),
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ]);

        $buttons = BotApi::inlineKeyboard([
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        return BotApi::sendLocation([
            'chat_id'       =>  $updates->getChat()->getId(),
            'latitude'      =>  '49.19202706211236',
            'longitude'     =>  '16.610699157670542',
            'reply_markup'  =>  $buttons,
        ]);
    }
}