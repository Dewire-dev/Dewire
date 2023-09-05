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
//        $this->middleware(function (Request $request, Closure $next)  {
//            abort_if(! $request->route()->project->canAccessModule('chats'), 403);
//
//            return $next($request);
//        });

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

    public function show(Project $project, Chat $chat, Request $request)
    {
        $messages = $this->chatRepo->getMessage($chat->id);
        $messages->load('sender');

        $unReadMessages = $this->chatRepo->getUnreadMessagesChat(auth()->user()->id, $chat->id);
        $countUnreadMessages = count($unReadMessages);

        $chatsUsers = $this->chatRepo->getUserInChat($chat->id);

        return Inertia::render('Chats/Show', compact('chat', 'messages', 'project', 'chatsUsers', 'unReadMessages', 'countUnreadMessages'));
    }

    public function store(Request $request): RedirectResponse
    {
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

    public function markReadMessages(Request $request)
    {

        foreach ($request->get('unReadMessages') as $MessagesRead)
        {
            MessageReadUser::whereId($MessagesRead['id'])->update([
                'read_at' => Carbon::now()
            ]);
        }

        $chat = $request->get('chat');
        $project = $request->get('project');

        $messages = $this->chatRepo->getMessage($chat['id']);
        $messages->load('sender');

        $unReadMessages = $this->chatRepo->getUnreadMessagesChat(auth()->user()->id, $chat['id']);
        $countUnreadMessages = count($unReadMessages);

        $chatsUsers = $this->chatRepo->getUserInChat($chat['id']);

        return Inertia::render('Chats/Show', compact('chat', 'messages', 'project', 'chatsUsers', 'unReadMessages', 'countUnreadMessages'));

    }

    public function createChats(Project $project, Request $request): RedirectResponse
    {

        $chat = Chat::create([
            'subject' => $request->get('chatSubject'),
            'name' => $request->get('chatName'),
            'project_id' => $request->get('projectId')
        ]);

        foreach ($request->get('chatUsers') as $chatUsers) {
            ChatsUser::create([
                'user_id' => $chatUsers,
                'chat_id' => $chat['id'],
            ]);
        }

        return response()->redirectToRoute('chats.index', ['project' => $request->get('chat')['project_id']]);
    }

}
