<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KanbanList extends Model
{
    use HasFactory;
    use HasUlids;

    protected $table = 'kanban_lists';
    protected $fillable = [
        'name',
        'color',
        'kanban_id',
    ];

    public function kanban(): BelongsTo
    {
        return $this->belongsTo(Kanban::class);
    }

}
