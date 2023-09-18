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
            abort_if(! $request->route()->project->canAccessModule('kanbans'), 403);

            return $next($request);
        });
    }

    public function store(Project $project, Kanban $kanban, Request $request): RedirectResponse
    {
        $values = $request->all();
        $values['position'] = $kanban->kanban_lists()->count() == 0
            ? 0
            : $kanban->kanban_lists->last()->position + 1;

        KanbanList::create($values);

        return to_route('kanbans.show', ['project' => $project, 'kanban' => $kanban]);
    }

    public function updateNameKanbanList(Project $project, KanbanList $kanbanList, Request $request) {
        $kanbanList->update(['name' => $request->get('name')]);

        return back()->banner('Nom de liste modifié avec succès');
    }

    public function updatePositionKanbanList(Project $project, Kanban $kanban, Request $request) {
        foreach ($request->get('list') as $index => $element) {
            $kanbanList = KanbanList::where('id', $element['id'])->first();
            $kanbanList->update(['position' => $index]);
        }

        return to_route('kanbans.show', ['project' => $project, 'kanban' => $kanban]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Kanban $kanban, KanbanList $kanbanList)
    {
        $kanbanList->delete();

        return to_route('kanbans.show', ['project' => $project, 'kanban' => $kanban])->banner('Liste supprimée avec succès');
    }
}
