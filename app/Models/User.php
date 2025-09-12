<?php

namespace App\Models;

use App\Traits\HasStatuses;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasRoles;
    use HasStatuses;
    use HasUuids;
    use MustVerifyEmail;
    use Notifiable;

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getRolesOptions(): array
    {
        return [
            'owner',
            'admin',
            'teacher',
            'student',
            'supervisor',
            'guest'
        ];
    }

    public static function isOwner(User|string|int|null $id = null): bool
    {
        $id ??= auth()->id();

        if ($id instanceof User) {
            $id = $id->id;
        }

        return User::find($id)?->hasRole('owner') ?? false;
    }

    public static function isAdmin(User|string|int|null $id = null): bool
    {
        $id ??= auth()->id();

        if ($id instanceof User) {
            $id = $id->id;
        }

        return User::find($id)?->hasRole('admin') ?? false;
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function statuses(): MorphToMany
    {
        return $this->morphToMany(Status::class, 'statusable');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin() || $this->isOwner();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar ?? null;
    }
}
