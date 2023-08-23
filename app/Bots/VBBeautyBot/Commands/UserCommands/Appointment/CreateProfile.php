<?php 

namespace App\Bots\VBBeautyBot\Commands\UserCommands\Appointment;

use App\Bots\VBBeautyBot\Commands\UserCommands\MenuCommand;
use App\Bots\VBBeautyBot\Models\Profile;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class CreateProfile extends Command
{
    public static $command = 'create_profile';

    public static $title = [
        'ru' => 'Создать профиль',
        'en' => 'Create profile'
    ];

    public static $usage = ['create_profile'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {   
        $notes = function ($key) {
            return $this->getConversation()->notes[$key] ?? null;
        };

        $buttons = BotApi::inlineKeyboard([
            [
                array("👤 Имя: {$notes('first_name')}", FirstName::$command, ''),
                array("👤 Фамилия: {$notes('last_name')}", LastName::$command, '')
            ],
            [array("☎️ Номер телефона: {$notes('phone')}", Phone::$command, '')],
            [
                array("👈 Назад", MenuCommand::$command, ''),
                array("Продолжить 👉", SaveProfile::$command, $notes('id')),
            ]
        ], 'client_id');

        $text = implode("\n", [
            "*Нам нужны кое-какие данные от тебя, чтобы сделать запись:*"."\n",
            "_Нажимай на кнопки с соответствующим пунктом, что бы заполнить информацию._"
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
