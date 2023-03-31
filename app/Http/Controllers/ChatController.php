<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ChatRepository;
use App\Models\Chat;
use App\Models\Project;
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
        $messages = $this->chatRepo->getMessage($chat->id);
        return Inertia::render('Chats/Show', compact('chat', 'messages'));
    }
}
