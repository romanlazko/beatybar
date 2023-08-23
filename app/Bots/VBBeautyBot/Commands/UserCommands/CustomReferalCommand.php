<?php 

namespace App\Bots\VBBeautyBot\Commands\UserCommands;

use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class CustomReferalCommand extends Command
{
    public static $command = 'referal_command';

    public static $title = '';

    public static $pattern = "/^(\/start\s)(referal)=(\d+)$/";

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        preg_match(static::$pattern, $updates->getMessage()?->getCommand(), $matches);

        $updates->getFrom()->setReferal($matches[3] ?? null);

        return $this->bot->executeCommand('/start');
    }
}