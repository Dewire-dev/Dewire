<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ChatRepository;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProjectController extends Controller
{

    private ChatRepository $chatRepo;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->authorizeResource(Project::class, 'project');
        $this->chatRepo = $chatRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $projects = auth()->user()->currentTeam?->projects()->get();
        return Inertia::render('Projects/Index', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request): \Illuminate\Http\RedirectResponse
    {
        $project = Project::create([
            ...$request->validated(),
            'team_id' => Auth::user()->currentTeam->id,
        ]);

        return to_route('projects.show', compact('project'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project): \Inertia\Response
    {
        $project->load('modules');

        if (Project::canAccessModule($project, 'Chat')) {
            $chats = $this->chatRepo->getChat($project->id);
            $unReadMessages = $this->chatRepo->getUnreadMessagesAllChatsProject($project->id, auth()->user()->id);
        } else {
            $chats = null;
        }
        if($chats != null) {
            foreach ($unReadMessages as $count) {
                $chats = $chats->map(function ($chat) use ($count) {
                    $chat->countUnreadMessages = $count->count();
                    return $chat;
                });
            }
        }

        return Inertia::render('Projects/Show', compact('project', 'chats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project): void
    {
        $project->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): void
    {
        $project->delete();
    }
}
