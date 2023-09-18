<?php 

namespace App\Bots\valeri_beautybar_bot\Commands\UserCommands\Appointment;

use App\Bots\valeri_beautybar_bot\Commands\UserCommands\MenuCommand;
use App\Bots\valeri_beautybar_bot\Models\Client;
use App\Bots\valeri_beautybar_bot\Models\Profile;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class AppointmentCommand extends Command
{
    public static $command = 'appointment';

    public static $title = [
        'ru' => '💅 Записаться на маникюр',
        'en' => '💅 Manicure appointment'
    ];

    public static $usage = ['appointment'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $this->getConversation()->clear();

        $client = Client::where('telegram_chat_id', DB::getChat($updates->getChat()->getId())->id)->first();

        if ($client) {
            $appointments = $client
                ->appointments()
                ->where('status', 'new')
                ->whereHas('schedule', function ($query) {
                    return $query->where('date', '>', now()->format('Y-m-d'));
                })
                ->get();

            if ($appointments->count() >= 2) {
                return BotApi::answerCallbackQuery([
                    'callback_query_id' => $updates->getCallbackQuery()->getId(),
                    'text'              => "Что бы записаться на новый термин, нужно отменить старую запись",
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