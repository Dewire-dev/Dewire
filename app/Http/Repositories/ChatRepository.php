<?php
namespace App\Http\Repositories;

use App\Models\Chat;
use App\Models\Message;

class ChatRepository {

    public function getUnreadMessagesChat($userId, $chatId)
    {
        return Message::where('chat_id', $chatId)
            ->where('message_read_users.user_id', $userId)
            ->whereNull('message_read_users.read_at')
            ->join('message_read_users', 'messages.id', '=', 'message_read_users.message_id')
            ->get();
    }

    public function getMessage(int $chatId): \Illuminate\Database\Eloquent\Collection|array
    {
        return Chat::find($chatId)->messages()->get();
    }

    public function getChat(string $projectId): \Illuminate\Database\Eloquent\Collection|array
    {
        return auth()->user()->chats()->where('project_id', $projectId)->get();
    }

    public function getUnreadMessagesAllChats($userId)
    {
        $chats = auth()->user()->chats()->get();

        $unreadMessages = [];

        foreach ($chats as $chat) {
            $messages = $this->getUnreadMessagesChat($userId, $chat->id);

            if (!empty($messages)) {
                $unreadMessages[$chat->id] = $messages;
            }
        }

        return $unreadMessages;
    }



}
