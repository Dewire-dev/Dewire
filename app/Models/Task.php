<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'description',
        'startAt',
        'endAt',
        'state',
        'type',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function userCreator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function taskLogs(): HasMany
    {
        return $this->hasMany(TaskLog::class);
    }

    public function taskTimeSpends(): HasMany
    {
        return $this->hasMany(TaskTimeSpend::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}