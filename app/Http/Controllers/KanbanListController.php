<?php

namespace App\Http\Controllers;

use App\Models\Kanban;
use App\Models\KanbanList;
use App\Models\Project;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KanbanListController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(function (Request $request, Closure $next)  {
            $project = Project::find($request->route()->project)->first();
            abort_if(! $project->canAccessModule('kanbans'), 403);

            return $next($request);
        });
    }

    public function store(Project $project, Kanban $kanban, Request $request): RedirectResponse
    {
        KanbanList::create($request->all());

        return to_route('kanbans.show', ['project' => $project, 'kanban' => $kanban]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project,Kanban $kanban, KanbanList $kanbanList)
    {
        $kanbanList->delete();

        return to_route('kanbans.show', ['project' => $project, 'kanban' => $kanban]);
    }
}
