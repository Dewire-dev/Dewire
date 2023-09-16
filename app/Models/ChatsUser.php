<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatsUser extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'user_id',
      'chat_id',
    ];

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }
}
