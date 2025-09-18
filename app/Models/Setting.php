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
        'flag' => 'boolean',
    ];

    public function getValueAttribute($value): mixed
    {
        if ($value === null) {
            return null;
        }

        $type = $this->attributes['type'] ?? 'string';
        $transform = Transform::from($value);

        return match ($type) {
            'bool', 'boolean' => $transform->toBoolean(),
            'arr', 'array' => $transform->toArray(),
            'json' => $transform->toJson(),
            default => $transform->toString(),
        };
    }

    public function setKeyAttribute($value): void
    {
        $this->attributes['key'] = str($value)
            ->lower()->slug('_')
            ->toString();
    }

    public function setValueAttribute($value): void
    {
        $this->attributes['type'] = gettype($value);
        $this->attributes['value'] = Transform::from($value)->toString();
    }
}
