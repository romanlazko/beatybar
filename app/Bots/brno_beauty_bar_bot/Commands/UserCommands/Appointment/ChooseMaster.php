<?php 

namespace App\Bots\brno_beauty_bar_bot\Commands\UserCommands\Appointment;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\brno_beauty_bar_bot\Models\Employee;
use App\Models\User;
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
        $users = User::all()
            ->map(function ($user) use ($updates){
                if ($user->just_ref) {
                    if ($user->telegram_chat_id == $updates->getChat()->getReferal()) {
                        return [array($user->name, SaveMaster::$command, $user->id)];
                    }
                    return [];
                }
                return [array($user->name, SaveMaster::$command, $user->id)];
            })
            ->toArray();

        $buttons = BotApi::inlineKeyboard([
            ...$users,
            [array("👈 Назад", MenuCommand::$command, '')]
        ], 'employee_id');

        return BotApi::returnInline([
            'text'          =>  "*Пожалуйста выбери мастера*",
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ]);
    }
}
