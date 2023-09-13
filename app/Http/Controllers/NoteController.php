<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveNoteRequest;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class NoteController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(function (Request $request, Closure $next)  {
            abort_if(! $request->route()->project->canAccessModule('notes'), 403);

            return $next($request);
        });

        $this->authorizeResource(Note::class, 'note');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $notes = Note::where('project_id', $project->id)->with(['user' => function ($query) {
            $query->select('id', 'name');
        }])->get();

        return Inertia::render('Notes/Index')->with(compact('project', 'notes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request, Project $project)
    {
        Note::create(array_merge(
            $request->validated(),
            [
                'project_id' => $project->id,
                'user_id' => Auth::id(),
            ],
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Note $note)
    {
        return Inertia::render('Notes/Show', compact('project', 'note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, Project $project, Note $note)
    {
        $note->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Note $note)
    {
        $note->delete();
    }

    /**
     * Save the specified resource.
     */
    public function save(SaveNoteRequest $request, Project $project, Note $note)
    {
        Gate::authorize('save', $note);

        $note->content = $request->input('content');
        $note->save();
    }
}
