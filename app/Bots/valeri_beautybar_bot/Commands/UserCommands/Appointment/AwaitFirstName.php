<?php 
namespace App\Bots\valeri_beautybar_bot\Commands\UserCommands\Appointment;

use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class AwaitFirstName extends Command
{
    public static $expectation = 'await_first_name';

    public static $pattern = '/^await_first_name$/';

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $text = $updates->getMessage()?->getText();

        if ($text === null) {
            $this->handleError("*Пришли пожалуйста имя в виде текста.*");
            return $this->bot->executeCommand(FirstName::$command);
        }

        if (!preg_match('/^[a-zA-Z ]+$/', $text)) {
            $this->handleError("*Пришли пожалуйста имя латинскими символами.*");
            return $this->bot->executeCommand(FirstName::$command);
        }

        if (iconv_strlen($text) > 30){
            $this->handleError("*Слишком много символов*");
            return $this->bot->executeCommand(FirstName::$command);
        }

        $this->getConversation()->update([
            'first_name' => $text
        ]);

        return $this->bot->executeCommand(CreateProfile::$command);
    }
}
