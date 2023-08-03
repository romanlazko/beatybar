<?php 

namespace App\Bots\brno_beauty_bar_bot\Commands\UserCommands\Appointment;

use App\Bots\brno_beauty_bar_bot\Models\Profile;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class SaveMaster extends Command
{
    public static $command = 'save_master';

    public static $usage = ['save_master'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        return $this->bot->executeCommand(ChooseWeek::$command);
    }
}
