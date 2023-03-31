<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'sender_id',
      'chat_id',
      'content',
      'created_at',
      'read_at',
      'updated_at'
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
