<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveNoteRequest;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use App\Models\Project;
use Inertia\Inertia;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $notes = Note::where('project_id', $project->id)->get();
        return Inertia::render('Notes/Index')->with(compact('project', 'notes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request, Project $project)
    {
        $note = Note::create(
            array_merge($request->validated(),
            [ 'project_id' => $project->id ],
        ));
        return to_route('projects.notes.show', compact('project', 'note'));
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
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update($request->validated());
        return back();
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
    public function save(SaveNoteRequest $request, Note $note)
    {
        $note->content = $request->input('content');
        $note->save();
    }
}
