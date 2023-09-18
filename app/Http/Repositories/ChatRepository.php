<?php
namespace App\Http\Repositories;

use App\Models\Chat;
use App\Models\ChatsUser;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function getUserInChat(int $chatId): \Illuminate\Database\Eloquent\Collection|array
    {
        return ChatsUser::where('chat_id', $chatId)
            ->join('users', 'chats_users.user_id', '=', 'users.id')
            ->select('chats_users.*', 'users.name as user_name', 'users.firstname as user_firstname', 'users.lastname as user_lastname')
            ->get();
    }

    public function getUnreadMessagesAllChatsProject($projectId, $userId)
    {
        $chats = $this->getChat($projectId);

        $unreadMessages = [];

        foreach ($chats as $chat) {
            $messages = $this->getUnreadMessagesChat($userId, $chat->id);

            if (!empty($messages)) {
                $unreadMessages[$chat->id] = $messages;
            }
        }

        return $unreadMessages;

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

    public function getUsersTeamNotChat($chatId): \Illuminate\Support\Collection
    {
        $chatsUsers = $this->getUserInChat($chatId)->pluck('user_id');
        $usersTeam = Auth::user()->currentTeam->users->pluck('id');

        return DB::table('users')
            ->whereIn('id', $usersTeam)
            ->whereNotIn('id', $chatsUsers)
            ->get();

    }

}
