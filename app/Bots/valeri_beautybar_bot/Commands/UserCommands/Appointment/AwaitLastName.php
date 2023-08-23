<?php 
namespace App\Bots\valeri_beautybar_bot\Commands\UserCommands\Appointment;

use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class AwaitLastName extends Command
{
    public static $expectation = 'await_last_name';

    public static $pattern = '/^await_last_name$/';

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $text = $updates->getMessage()?->getText();

        if ($text === null) {
            $this->handleError("*Пришли пожалуйста фамилию в виде текста.*");
            return $this->bot->executeCommand(LastName::$command);
        }

        if (!preg_match('/^[a-zA-Z ]+$/', $text)) {
            $this->handleError("*Пришли пожалуйста фамилию латинскими символами.*");
            return $this->bot->executeCommand(LastName::$command);
        }

        if (iconv_strlen($text) > 30){
            $this->handleError("*Слишком много символов*");
            return $this->bot->executeCommand(LastName::$command);
        }

        $this->getConversation()->update([
            'last_name' => $text
        ]);

        return $this->bot->executeCommand(CreateProfile::$command);
    }
}