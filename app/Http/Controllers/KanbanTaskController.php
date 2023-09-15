<?php

namespace App\Http\Controllers;

use App\Models\Kanban;
use App\Models\KanbanList;
use App\Models\KanbanTask;
use App\Models\Project;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KanbanTaskController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(function (Request $request, Closure $next) {
            abort_if(!$request->route()->project->canAccessModule('kanbans'), 403);

            return $next($request);
        });
    }

    public function store(Project $project, Kanban $kanban, Request $request): RedirectResponse
    {
        KanbanTask::create($request->get('item'));

        return back();
    }

    public function update(Project $project, Kanban $kanban, KanbanTask $kanbanTask, Request $request)
    {
        $kanbanTask->update($request->get('item'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Kanban $kanban, KanbanTask $kanbanTask)
    {
        $kanbanTask->delete();

        return to_route('kanbans.show', ['project' => $project, 'kanban' => $kanban]);
    }

    public function updateTaskPosition(Project $project, KanbanTask $kanbanTask, Request $request)
    {
        request()->validate([
            'kanban_list_id' => ['required', 'exists:kanban_lists,id'],
            'position' => ['required', 'numeric']
        ]);

        $kanbanTask->update([
            'kanban_list_id' => $request->get('kanban_list_id'),
            'position' => round($request->get('position'), 5)
        ]);

        return back();
    }
}
