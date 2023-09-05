<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Module;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
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
        $project->loadMissing('modules');

        $availableModules = Module::query()->whereDoesntHave('projects', function ($query) use ($project) {
            $query->where('project_id', $project->id);
        })->get();

        return Inertia::render('Projects/Show', compact('project', 'availableModules'));
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

    /**
     * Attach the specified resource.
     */
    public function attachModule(Project $project, Module $module): void
    {
        Gate::authorize('attachModule', $project);

        $project->modules()->attach($module);
    }

    /**
     * Detach the specified resource.
     */
    public function detachModule(Project $project, Module $module): void
    {
        Gate::authorize('detachModule', $project);

        $project->modules()->detach($module);
    }
}
