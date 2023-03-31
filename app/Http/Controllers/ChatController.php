<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        return to_route('dashboard');
    }

    public function show(Project $project, Chat $chat)
    {
        return Inertia::render('Chats/Show', compact('chat'));
    }
}
