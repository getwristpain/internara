<?php

namespace App\Models;

use App\Helpers\Transform;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'school_id',
        'name',
        'description',
        'slug',
    ];

    public function setSlugAttribute(): void
    {
        $this->attributes['slug'] = str($this->name)->slug('-')->toString();
    }

    public function initials(): string
    {
        return Transform::from($this->attributes['name'] ?? null)->initials()->toString();
    }
}
