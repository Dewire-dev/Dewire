<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'description',
        'scheduled_time',
        'start_at',
        'end_at',
        'state',
        'type',
        'project_id',
        'user_creator_id',
        'kanban_task_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function kanban_task(): BelongsTo
    {
        return $this->belongsTo(KanbanTask::class);
    }

    public function userCreator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function taskComments(): HasMany
    {
        return $this->hasMany(TaskComment::class);
    }

    public function taskTimeSpends(): HasMany
    {
        return $this->hasMany(TaskTimeSpend::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tasks_users');
    }
}
