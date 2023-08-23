<?php 

namespace App\Bots\valeri_beautybar_bot\Commands\UserCommands\Appointment;

use App\Bots\valeri_beautybar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\valeri_beautybar_bot\Models\Employee;
use App\Models\User as Master;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class ChooseMaster extends Command
{
    public static $command = 'choose_master';

    public static $usage = ['choose_master'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $masters = Master::all()
            ->map(function ($master) use ($updates){
                if ($master->just_ref) {
                    if ($master->telegram_chat_id == $updates->getChat()->getReferal()) {
                        return [array($master->name, SaveMaster::$command, $master->id)];
                    }
                    return [];
                }
                return [array($master->name, SaveMaster::$command, $master->id)];
            })
            ->toArray();

        $buttons = BotApi::inlineKeyboard([
            ...$masters,
            [array("👈 Назад", MenuCommand::$command, '')]
        ], 'master_id');

        return BotApi::returnInline([
            'text'          =>  "*Выбери мастера:*",
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ]);
    }
}
