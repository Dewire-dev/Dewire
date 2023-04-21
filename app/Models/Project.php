<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasUlids;
    use HasFactory;

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'projects_modules');
    }
}
