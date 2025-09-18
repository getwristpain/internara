<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'school_id',
        'title',
        'year',
        'semester',
        'date_start',
        'date_end',
        'status',
        'description',
        'slug',
    ];

    public function setSlugAttribute(): void
    {
        $slug = implode(' ', [
            $this->year,
            $this->semester,
            $this->title,
        ]);

        $this->attributes['slug'] = str($slug)->slug('-')->toString();
    }
}
