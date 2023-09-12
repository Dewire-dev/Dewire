<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kanban extends Model
{
    use HasFactory;
    use HasUlids;

    protected $table = 'kanbans';
    protected $fillable = [
        'name',
        'project_id'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function kanban_lists(): HasMany
    {
        return $this->hasMany(KanbanList::class);
    }
}
