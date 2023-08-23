<?php 

namespace App\Bots\valeri_beautybar_bot\Commands\UserCommands\Appointment;

use App\Bots\valeri_beautybar_bot\Commands\UserCommands\MenuCommand;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class LastName extends Command
{
    public static $command = 'last_name';

    public static $usage = ['last_name'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $updates->getFrom()->setExpectation(AwaitLastName::$expectation);

        $buttons = BotApi::inlineKeyboard([
            [
                array("👈 Назад", CreateProfile::$command, ''),
                array(MenuCommand::getTitle('ru'), MenuCommand::$command, ''),
            ]
        ]);

        $text = implode("\n", [
            "*Напиши свою фамилию:*"."\n",
            "_Только фамилия, ЛАТИНИЦЕЙ_"."\n",
            "*Пример*: Pupkin",
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