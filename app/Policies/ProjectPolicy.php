<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasTeamPermission($user->currentTeam, 'project:list');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        return $user->belongsToTeam($project->team) &&
            $user->hasTeamPermission($project->team, 'project:view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasTeamPermission($user->currentTeam, 'project:create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        return $user->belongsToTeam($project->team) &&
            $user->hasTeamPermission($project->team, 'project:update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->belongsToTeam($project->team) &&
            $user->hasTeamPermission($project->team, 'project:delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        //
    }

    /**
     * Determine whether the user can attach a model.
     */
    public function attachModule(User $user, Project $project): bool
    {
        return $user->belongsToTeam($project->team) &&
            $user->hasTeamPermission($project->team, 'module:attach');
    }

    /**
     * Determine whether the user can detach a model.
     */
    public function detachModule(User $user, Project $project): bool
    {
        return $user->belongsToTeam($project->team) &&
            $user->hasTeamPermission($project->team, 'module:detach');
    }
}
