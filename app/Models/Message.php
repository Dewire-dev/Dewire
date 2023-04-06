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
      'updated_at'
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function readByUsers()
    {
        return $this->belongsToMany(User::class, 'message_read_users')
            ->withPivot('read_at')
            ->withTimestamps();
    }
}
