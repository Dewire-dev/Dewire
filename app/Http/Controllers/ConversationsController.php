<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConversationsController extends Controller
{
    public function index()
    {
        return to_route('dashboard');
    }

    public function show(Conversation $conversation)
    {
        return Inertia::render('Conversations/Show', compact('conversation'));
    }
}
