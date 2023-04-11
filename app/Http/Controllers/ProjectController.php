<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ChatRepository;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{

    private ChatRepository $chatRepo;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepo = $chatRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = \App\Models\Project::all();
        return Inertia::render('Projects/Index', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $chats = $this->chatRepo->getChat($project->id);
        $unReadMessages = $this->chatRepo->getUnreadMessagesAllChatsProject($project->id, auth()->user()->id);

        foreach ($unReadMessages as $count) {
            $chats = $chats->map(function ($chat) use ($count) {
                $chat->countUnreadMessages = $count->count();
                return $chat;
            });
        }

        return Inertia::render('Projects/Show', compact('project', 'chats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
    }
}
