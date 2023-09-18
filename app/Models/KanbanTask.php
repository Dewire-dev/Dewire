<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        'date_start',
        'date_end',
        'is_archived',
        'scheduled_time',
    ];

    const POSITION_GAP = 60000;
    const POSITION_MIN = 0.00002;

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->position = self::query()->where('kanban_list_id', $model->kanban_list_id)->orderByDesc('position')->first()?->position + self::POSITION_GAP;
        });

        static::saved(function ($model) {
            if ($model->position < self::POSITION_MIN) {
                DB::statement("SET @previousPosition := 0");
                DB::statement("
                    UPDATE card
                    SET position = (@previousPosition := @previousPosition + ?)
                    WHERE card_list_id = ?
                    ORDER BY position

                ", [
                        self::POSITION_GAP,
                        $model->card_list_id
                    ]
                );
            }
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
