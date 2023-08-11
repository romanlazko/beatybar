<?php 

namespace App\Bots\brno_beauty_bar_bot\Commands\UserCommands;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\Appointment\AppointmentCommand;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class MenuCommand extends Command
{
    public static $command = '/menu';

    public static $title = [
        'ru' => '🏠 Главное меню',
        'en' => '🏠 Menu'
    ];

    public static $usage = ['/menu', 'menu', 'Главное меню', 'Menu'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $buttons = BotApi::inlineKeyboard([
            [array(AppointmentCommand::getTitle(), AppointmentCommand::$command, '')],
            [array(MyAppointments::getTitle(), MyAppointments::$command, '')],
            [array(About::getTitle(), About::$command, '')],
        ]);

        $text = implode("\n", [
            "Добро пожаловать в BeautyBar! 🌟"."\n",

            "Здесь ты можешь легко и удобно записаться на маникюр к нашим мастерам." ."\n", 
            
            "Выбери удобное время и готовься к невероятному обновлению своего образа. 💋",
        ]);

        $data = [
            'text'          =>  $text,
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()->getMessageId(),
            'disable_web_page_preview' => true
        ];

        return BotApi::returnInline($data);
    }
}