<?php

namespace App\Http\Controllers;

use App\Http\Requests\KanbanRequest;
use App\Models\Kanban;
use App\Models\Project;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KanbanController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(function (Request $request, Closure $next)  {
            abort_if(! $request->route()->project->canAccessModule('kanbans'), 403);

            return $next($request);
        });
    }

    public function index(Project $project)
    {
        $kanbans = $project->kanbans;

        return Inertia::render('Kanban/Index', compact('project', 'kanbans'));
    }


    public function store(KanbanRequest $request, Project $project): RedirectResponse
    {
        $values = $request->all();
        $values['project_id'] = $project->id;

        Kanban::create($values);

        return to_route('kanbans.index', ['project' => $project->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Kanban $kanban)
    {
        $lists = $kanban->kanban_lists()->with('tasks')->get();
        $lists->load('tasks.task.users');

        $members = $project->team->team_users->pluck('full_name', 'id');

        return Inertia::render('Kanban/Show', compact('project', 'kanban', 'lists', 'members'));
    }

    public function updateNameKanban(Project $project, Kanban $kanban, KanbanRequest $request)
    {
        $kanban->update([
            'name' => $request->get('name'),
        ]);

        return back()->banner('Nom du tableau modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Kanban $kanban)
    {
        $kanban->delete();
    }
}
