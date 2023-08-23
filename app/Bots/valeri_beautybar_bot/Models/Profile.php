<?php

namespace App\Bots\valeri_beautybar_bot\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory; use SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
