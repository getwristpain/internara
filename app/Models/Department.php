<?php

namespace App\Models;

use App\Models\School;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = ['name', 'code'];

    public function school(): School
    {
        return School::first();
    }

    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }
}
