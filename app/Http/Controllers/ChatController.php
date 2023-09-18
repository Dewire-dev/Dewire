<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ChatRepository;
use App\Http\Requests\StoreUserChatRequest;
use App\Models\Chat;
use App\Models\ChatsUser;
use App\Models\Message;
use App\Models\MessageReadUser;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $users = Auth::user()->currentTeam->users;
        foreach ($chats as $chat) {
            $unReadMessage = $this->chatRepo->getUnreadMessagesChat(auth()->user()->id, $chat->id);
            $countUnreadMessage = count($unReadMessage);
            $chat->countUnreadMessage = $countUnreadMessage;
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
        $usersTeamNotChat = $this->chatRepo->getUsersTeamNotChat($chat->id);
        $checkedUsersTeamNotChat = [];
        foreach ($usersTeamNotChat as $user) {
            $userArray = (array) $user;
            $userArray['checked'] = false;
            $checkedUsersTeamNotChat[] = $userArray;
        }

        return Inertia::render('Chats/Show', compact('chat', 'messages', 'project', 'chatsUsers', 'unReadMessages', 'countUnreadMessages', 'checkedUsersTeamNotChat'));
    }

    public function store(Project $project, Request $request)
    {
        $chatSubject = $request->input('chatSubject');
        $chatName = $request->input('chatName');
        $chatUsers = $request->input('chatUsers');

        $chat = Chat::create([
            'subject' => $chatSubject,
            'name' => $chatName,
            'project_id' => $project->id,
        ]);

        foreach ($chatUsers as $user) {
            ChatsUser::create([
                'user_id' => $user,
                'chat_id' => $chat->id,
            ]);
        }
    }

    public function markReadMessages(Project $project, Chat $chat, Request $request)
    {
        foreach ($request->get('unReadMessages') as $MessagesRead)
        {
            MessageReadUser::whereId($MessagesRead['id'])->update([
                'read_at' => Carbon::now()
            ]);
        }
    }

    public function createMessage(Project $project, Chat $chat, Request $request)
    {
        $content = $request->input('content');

        $message = Message::create([
            'sender_id' => auth()->user()->id,
            'chat_id' => $chat->id,
            'content' => $content,
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
    }

    public function addUser(Request $request, Project $project, Chat $chat)
    {
        $users = $request->get('users');
        foreach ($users as $user) {
            ChatsUser::firstOrCreate([
                'user_id' => $user,
                'chat_id' => $chat->id
            ]);
        }
    }

    public function deleteUser(Request $request, Project $project)
    {
        $chatId = $request->get('chatId');

        ChatsUser::where('user_id', auth()->user()->id)
            ->where('chat_id', $chatId)
            ->delete();
        return to_route('chats.index', compact('project'));
    }

}
