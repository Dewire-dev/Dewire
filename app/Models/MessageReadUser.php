<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReadUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'message_id',
        'user_id',
        'read_at',
        'created_at',
        'updated_at'
    ];
}
