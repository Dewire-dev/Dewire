<?php

namespace App\Http\Controllers;

use App\Enum\TaskState;
use App\Models\Kanban;
use App\Models\KanbanList;
use App\Models\KanbanTask;
use App\Models\Project;
use App\Models\Task;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        $values = $request->get('item');
        $kanbanTask = KanbanTask::create($values);

        $task = Task::create([
            'project_id'      => $kanbanTask->list->kanban->project->id,
            'user_creator_id' => auth()->user()->id,
            'label'           => $values['name'],
            'description'     => $values['description'],
            'state'           => TaskState::TO_DO,
            'kanban_task_id'  => $kanbanTask->id,
            'start_at'        => Carbon::now(),
        ]);

        if(isset($values['members'])) {
            $task->users()->sync($values['members']);
        }

        return back();
    }

    public function getMembersTask(Project $project, KanbanTask $kanbanTask)
    {
        return response()->json([
            'members' => $kanbanTask->task->users->pluck('name', 'id')->toArray(),
        ]);
    }

    public function update(Project $project, Kanban $kanban, KanbanTask $kanbanTask, Request $request)
    {
        $values = $request->get('item');
        $kanbanTask->update($values);

        $task = Task::where('kanban_task_id', $kanbanTask->id)->first();
        $task->update([
            'label'           => $values['name'],
            'description'     => $values['description'],
        ]);

        if(isset($values['members'])) {
            $task->users()->sync($values['members']);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Kanban $kanban, KanbanTask $kanbanTask)
    {
        $task = Task::where('kanban_task_id', $kanbanTask->id)->first();
        $task->users()->detach();
        $task->delete();

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
