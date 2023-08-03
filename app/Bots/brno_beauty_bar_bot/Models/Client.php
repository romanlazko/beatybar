<?php

namespace App\Bots\brno_beauty_bar_bot\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Romanlazko\Telegram\Models\TelegramChat;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function telegram_chat()
    {
        return $this->belongsTo(TelegramChat::class);
    }

    public function chat()
    {
        return $this->belongsTo(TelegramChat::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
