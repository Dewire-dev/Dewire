<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'subject',
      'name',
      'project_id',
      'created_at',
      'updated_at'
    ];

    public  function users()
    {
        return $this->belongsToMany(User::class, 'chats_users');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}
