<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ChatRepository;
use App\Models\Chat;
use App\Models\ChatsUser;
use App\Models\Message;
use App\Models\MessageReadUser;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{

    private ChatRepository $chatRepo;

    /**
     * Create a new controller instance.
     */
    public function __construct(ChatRepository $chatRepository)
    {
        $this->middleware(function (Request $request, Closure $next)  {
            abort_if(! $request->route()->project->canAccessModule('chats'), 403);

            return $next($request);
        });

        $this->chatRepo = $chatRepository;
    }

    public function index(Project $project)
    {
        $chats = $this->chatRepo->getChat($project->id);
        $unReadMessages = $this->chatRepo->getUnreadMessagesAllChatsProject($project->id, auth()->user()->id);
        $users = User::all();

        foreach ($unReadMessages as $count) {
            $chats = $chats->map(function ($chat) use ($count) {
                $chat->countUnreadMessages = $count->count();
                return $chat;
            });
        }

        return Inertia::render('Chats/Index', compact('project', 'chats', 'users'));
    }

    public function show(Project $project, Chat $chat)
    {
        $messages = $this->chatRepo->getMessage($chat->id);
        $messages->load('sender');

        $unReadMessages = $this->chatRepo->getUnreadMessagesChat(auth()->user()->id, $chat->id);
        $countUnreadMessages = count($unReadMessages);

        $chatsUsers = $this->chatRepo->getUserInChat($chat->id);

        return Inertia::render('Chats/Show', compact('chat', 'messages', 'project', 'chatsUsers', 'unReadMessages', 'countUnreadMessages'));
    }

    public function store(Project $project, Request $request): RedirectResponse
    {
        $chat = Chat::create([
            'name' => $request->input('chatName'),
            'subject' => $request->input('chatSubject'),
            'project_id' => $project->id,
        ]);

        foreach ($request->input('chatUsers') as $user) {
            ChatsUser::create([
                'user_id' => $user,
                'chat_id' => $chat->id,
            ]);
        }

        return to_route('chats.index', compact('project'));
    }

    public function markReadMessages(Project $project, Chat $chat, Request $request)
    {
        foreach ($request->get('unReadMessages') as $MessagesRead)
        {
            MessageReadUser::whereId($MessagesRead['id'])->update([
                'read_at' => Carbon::now()
            ]);
        }

        return to_route('chats.show', compact('project', 'chat'));
    }

    public function createMessage(Project $project, Chat $chat, Request $request): RedirectResponse
    {
        $message = Message::create([
            'sender_id' => auth()->user()->id,
            'chat_id' => $chat->id,
            'content' => $request->input('content'),
        ]);

        foreach ($chat->users as $user)
        {
            if ($user->id !== auth()->user()->id)
            {
                MessageReadUser::create([
                    'message_id' => $message->id,
                    'user_id' => $user->id,
                    'read_at' => null,
                ]);
            }
        }

        return to_route('chats.show', compact('project', 'chat'));
    }

}
