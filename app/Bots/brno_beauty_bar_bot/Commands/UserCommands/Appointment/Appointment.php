<?php 

namespace App\Bots\brno_beauty_bar_bot\Commands\UserCommands\Appointment;

use App\Bots\brno_beauty_bar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\brno_beauty_bar_bot\Models\Client;
use App\Bots\brno_beauty_bar_bot\Models\Profile;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Appointment extends Command
{
    public static $command = 'appointment';

    public static $title = [
        'ru' => 'Записаться на маникюр 💅',
        'en' => 'Appoint '
    ];

    public static $usage = ['appointment'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $this->getConversation()->clear();

        $client = Client::where('telegram_chat_id', DB::getChat($updates->getChat()->getId())->id)->first();

        if ($client) {
            if (!$client->appointments()->where('status', 'new')->whereHas('schedule', function ($query) {
                return $query->where('date', '>=', now()->format('Y-m-d'));
            })->get()->isEmpty()) {
                return BotApi::answerCallbackQuery([
                    'callback_query_id' => $updates->getCallbackQuery()->getId(),
                    'text'              => "Вы не можете записаться на новый термин",
                    'show_alert'        => true
                ]);
            }
    
            $this->getConversation()->update(
                $client?->toArray() ?? []
            );
        }
        
    
        return $this->bot->executeCommand(CreateProfile::$command);
    }
}