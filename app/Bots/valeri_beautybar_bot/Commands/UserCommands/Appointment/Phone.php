<?php 

namespace App\Bots\valeri_beautybar_bot\Commands\UserCommands\Appointment;

use App\Bots\valeri_beautybar_bot\Commands\UserCommands\MenuCommand;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Phone extends Command
{
    public static $command = 'phone';

    public static $usage = ['phone'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $updates->getFrom()->setExpectation(AwaitPhone::$expectation);

        $buttons = BotApi::inlineKeyboard([
            [
                array("👈 Назад", CreateProfile::$command, ''),
                array(MenuCommand::getTitle('ru'), MenuCommand::$command, ''),
            ]
        ]);

        $text = implode("\n", [
            "*Напиши свой чешский номер телефона:*"."\n",
		    "*Пример*: +420 777 123 487",
        ]);

        return BotApi::returnInline([
            'text'          =>  $text,
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ]);
    }
}