<?php

namespace App\Bots\VBBeautyBot\Http\Controllers;

use App\Bots\VBBeautyBot\Http\Requests\ClientStoreRequest;
use App\Bots\VBBeautyBot\Models\Client;
use App\Bots\VBBeautyBot\Models\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Romanlazko\Telegram\Models\TelegramChat;

class ClientController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return back()->with([
                'ok' => false,
                'description' => 'You have no permission'
            ]);
        }

        $clients = Client::with('telegram_chat')->paginate(10);

        return view('VBBeautyBot::client.index', compact(
            'clients'
        ));
    }

    public function edit(Client $client)
    {
        $user = auth()->user();

        if (!$user->isAdmin()) {
            return back()->with([
                'ok' => false,
                'description' => 'You have no permission'
            ]);
        }

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

        $telegram_chats = DB::select("
            SELECT *
            FROM telegram_chats
            WHERE NOT EXISTS (
                SELECT 1
                FROM clients
                WHERE clients.telegram_chat_id = telegram_chats.id
            )
        ");

		return view('VBBeautyBot::client.edit', compact(
            'client',
            'schedule',
            'appointments',
            'telegram_chats'
        ));
    }

    public function update(Client $client, Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return back()->with([
                'ok' => false,
                'description' => 'You have no permission'
            ]);
        }

        $client->update([
            'telegram_chat_id' => $request->telegram_chat_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
        ]);

        $client->telegram_chat()->update([
            'referal_id' => $request->referal_id
        ]);

        return redirect()->route('VBBeautyBot.client.index');
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return back()->with([
                'ok' => false,
                'description' => 'You have no permission'
            ]);
        }

        $telegram_chats = DB::select("
            SELECT *
            FROM telegram_chats
            WHERE NOT EXISTS (
                SELECT 1
                FROM clients
                WHERE clients.telegram_chat_id = telegram_chats.id
            )
        ");

        // $telegram_chats = TelegramChat::all()
        //     ->filter(function ($telegram_chat) {
        //         return $telegram_chat->chat_id == null;
        //     });

		return view('VBBeautyBot::client.create', compact('telegram_chats'));
    }

    public function store(ClientStoreRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            return back()->with([
                'ok' => false,
                'description' => 'You have no permission'
            ]);
        }
        
		Client::create([
            'telegram_chat_id' => $request->telegram_chat_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
        ]);

        return redirect()->route('VBBeautyBot.client.index');
    }
}
