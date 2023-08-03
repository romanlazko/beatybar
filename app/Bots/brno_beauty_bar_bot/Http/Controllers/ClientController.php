<?php

namespace App\Bots\brno_beauty_bar_bot\Http\Controllers;

use App\Bots\brno_beauty_bar_bot\Http\Requests\ClientStoreRequest;
use App\Bots\brno_beauty_bar_bot\Models\Client;
use App\Bots\brno_beauty_bar_bot\Models\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Romanlazko\Telegram\Models\TelegramChat;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('telegram_chat')->paginate(10);

		return view('brno_beauty_bar_bot::client.index', compact(
            'clients'
        ));
    }

    public function edit(Client $client)
    {
        $user = auth()->user();

        $schedule = Schedule::with('appointment')
            ->orderBy('date', 'asc')
            ->where('user_id', $user->isAdmin() ? request('user', $user->id) : $user->id)
            ->where('date', '>=', now()->format('Y-m-d'))
            ->get()
            ->filter(function ($schedule) {
                return $schedule->appointment == null;
            })
            ->groupBy(function ($schedule) {
                return $schedule->date->format('Y-m-d');
            });
        
        $appointments = $client->appointments->sortBy('schedule.date');

        $telegram_chats = TelegramChat::with('client')
            ->get()
            ->filter(function ($telegram_chat) {
                return $telegram_chat->client == null;
            });

		return view('brno_beauty_bar_bot::client.edit', compact(
            'client',
            'schedule',
            'appointments',
            'telegram_chats'
        ));
    }

    public function update(Client $client, Request $request)
    {
        $client->update([
            'telegram_chat_id' => $request->telegram_chat_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
        ]);

        $client->telegram_chat()->update([
            'referal_id' => $request->referal_id
        ]);

        return redirect()->route('brno_beauty_bar_bot.client.index');
    }

    public function create()
    {
        $telegram_chats = TelegramChat::with('client')
            ->get()
            ->filter(function ($telegram_chat) {
                return $telegram_chat->client == null;
            });

		return view('brno_beauty_bar_bot::client.create', compact('telegram_chats'));
    }

    public function store(ClientStoreRequest $request)
    {
		Client::create([
            'telegram_chat_id' => $request->telegram_chat_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
        ]);

        return redirect()->route('brno_beauty_bar_bot.client.index');
    }
}
