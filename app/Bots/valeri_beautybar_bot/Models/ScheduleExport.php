<?php

namespace App\Bots\valeri_beautybar_bot\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleExport extends Model
{
    use HasFactory; use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class)->with('client')->whereIn('status', ['new', 'done']);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class)->with('client');
    }

    public function scopeUnoccupied($query) 
    {
        return $query->where(function ($query) {
            $query->whereHas('appointments', function ($query) {
                $query->whereNotIn('status', ['new']);
            });
        })
        ->orWhere(function ($query) {
            $query->doesntHave('appointments');
        });
    }
}
