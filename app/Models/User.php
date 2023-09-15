<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasUlids;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password','firstname','lastname',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function role()
    {
        return $this->teamRole($this->currentTeam)->key;
    }

    public function permissions()
    {
        return $this->teamPermissions($this->currentTeam);
    }

    public function taskComments(): HasMany
    {
        return $this->hasMany(TaskComment::class);
    }

    public function taskTimeSpends(): HasMany
    {
        return $this->hasMany(TaskTimeSpend::class);
    }

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'tasks_users');
    }

    public  function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'chats_users');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function readMessages(): BelongsToMany
    {
        return $this->belongsToMany(Message::class, 'message_read_users')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    public function isAdmin(): bool
    {
        return in_array($this->email, [
            'mathieu.neyret@ynov.com',
            'anael.bonnafous@ynov.com',
            'logan.lesaux@ynov.com',
            'theonicolas19@outlook.com',
        ]);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }
}
