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
        'name',
        'slug',
        'description',
        'school_id'
    ];

    public function setSlugAttribute()
    {
        if (!$this->slug) {
            $this->attributes['slug'] = str($this->name)->slug();
        }
    }

    public function initials(): string
    {
        return Transform::from($this->attributes['name'] ?? null)->initials()->toString();
    }
}
