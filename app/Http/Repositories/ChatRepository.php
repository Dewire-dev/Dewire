<?php
namespace App\Http\Repositories;

use App\Models\Chat;

class ChatRepository {

    public function getMessage(int $chatId): \Illuminate\Database\Eloquent\Collection|array
    {
        return Chat::find($chatId)->messages()->get();
    }

    public function getChat(string $projectId): \Illuminate\Database\Eloquent\Collection|array
    {
        return auth()->user()->chats()->where('project_id', $projectId)->get();
    }

}
