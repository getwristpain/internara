<?php

namespace App\Models;

use App\Helpers\Media;
use App\Traits\HasStatuses;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
    /**
     * @use HasFactory<\Database\Factories\UserFactory>
     */
    use HasFactory;
    use HasRoles;
    use HasStatuses;
    use HasUuids;
    use MustVerifyEmail;
    use Notifiable;

    /**
     * @var string The primary key type.
     */
    protected $keyType = 'string';

    /**
     * @var bool Indicates if the IDs are auto-incrementing.
     */
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
        'avatar_url',
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

    // ---

    /**
     * Gets the user's profile.
     *
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Gets the statuses associated with the user.
     *
     * @return MorphToMany
     */
    public function statuses(): MorphToMany
    {
        return $this->morphToMany(Status::class, 'statusable');
    }

    // ---

    /**
     * Gets or sets the user's avatar URL.
     *
     * @return Attribute
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => Media::asset($value)
        );
    }

    /**
     * Gets the user's initials.
     *
     * @return string
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // ---

    /**
     * Checks if the user can access the Filament panel.
     *
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['owner', 'admin']);
    }

    /**
     * Gets the URL for the user's Filament avatar.
     *
     * @return string|null
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ?? null;
    }

    /**
     * Gets the available roles for the application.
     *
     * @return list<string>
     */
    public static function getRolesOptions(): array
    {
        return [
            'owner',
            'admin',
            'teacher',
            'student',
            'supervisor',
        ];
    }
}
