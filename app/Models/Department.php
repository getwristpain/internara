<?php

namespace App\Models;

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
        $initials = str($this->attributes['name'] ?? null)
            ->explode(' ')
            ->map(fn ($word) => str($word)->substr(0, 1)->upper())
            ->implode('');

        return $initials;
    }
}
