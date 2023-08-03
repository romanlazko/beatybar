<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Romanlazko\Telegram\App\Telegram;
use Romanlazko\Telegram\Models\TelegramChat;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telegram_chat_id' => ['required', 'integer', 'unique:'.User::class],
        ]);

        if (TelegramChat::where('chat_id', $request->telegram_chat_id)->first()?->role === 'admin') {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telegram_chat_id' => $request->telegram_chat_id,
            ]);
    
            event(new Registered($user));
    
            Auth::login($user);
    
            return redirect(RouteServiceProvider::HOME);
        }
        return back()->with([
            'ok' => false,
            'description' => "You are not admin!"
        ]);
    }
}
