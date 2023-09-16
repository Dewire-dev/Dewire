<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KanbanTask extends Model
{
    use HasFactory;
    use HasUlids;

    protected $table = 'kanban_tasks';
    protected $fillable = [
        'position',
        'kanban_list_id',
        'name',
        'description',
    ];

    const POSITION_GAP = 60000;

    protected static function booted()
    {
        static::creating(function($model) {
            $model->position = self::query()->where('kanban_list_id', $model->kanban_list_id)->orderByDesc('position')->first()?->position + self::POSITION_GAP;
        });
    }

    public function list(): BelongsTo
    {
        return $this->belongsTo(KanbanList::class, 'kanban_list_id');
    }

    public function task(): HasOne
    {
        return $this->hasOne(Task::class, 'kanban_task_id');
    }
}
