<?php

namespace App\Models;

use App\Helpers\Transform;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'flag',
        'label',
        'description'
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function getValueAttribute($value): mixed
    {
        return Transform::from($value)->to($this->attributes['type']);
    }

    public function setKeyAttribute($value): void
    {
        $this->attributes['key'] = Transform::from($value)
                                        ->lower()
                                        ->slug('_')
                                        ->toString();
    }

    public function setValueAttribute($value): void
    {
        $this->attributes['type'] = gettype($value);
        $this->attributes['value'] = Transform::from($value)->toString();
    }

}
