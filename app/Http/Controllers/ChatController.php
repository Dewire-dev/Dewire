<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ChatRepository;
use App\Models\Chat;
use App\Models\ChatsUser;
use App\Models\Message;
use App\Models\MessageReadUser;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{

    private ChatRepository $chatRepo;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepo = $chatRepository;
    }

    public function index()
    {
        return to_route('dashboard');
    }

    public function show(Project $project, Chat $chat)
    {
        abort_if(!Project::canAccessModule($project, 'Chat'), 403);

        $messages = $this->chatRepo->getMessage($chat->id);
        $messages->load('sender');

        $unReadMessages = $this->chatRepo->getUnreadMessagesChat(auth()->user()->id, $chat->id);
        $countUnreadMessages = count($unReadMessages);

        $chatsUsers = $this->chatRepo->getUserInChat($chat->id);

        return Inertia::render('Chats/Show', compact('chat', 'messages', 'project', 'chatsUsers', 'unReadMessages', 'countUnreadMessages'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if(!Project::canAccessModule(Project::find($request->get('chat')['project_id']), 'Chat'), 403);

        $message = Message::create([
            'sender_id' => auth()->user()->id,
            'chat_id' => $request->get('chat')['id'],
            'content' => $request->get('form')['content'],
        ]);

        foreach ($request->get('chatsUsers') as $chatsUsers)
        {
            if ($chatsUsers['user_id'] !== auth()->user()->id)
            {
                MessageReadUser::create([
                    'message_id' => $message->id,
                    'user_id' => $chatsUsers['user_id'],
                    'read_at' => null,
                ]);
            }
        }

        return response()->redirectToRoute('chats.show', ['project' => $request->get('chat')['project_id'], 'chat' => $request->get('chat')['id']]);
    }
}
