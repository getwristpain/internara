<?php

namespace App\Models;

use App\Helpers\Sanitizer;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasStatus;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'value',
        'value_type',
        'type',
        'label',
        'description',
        'flag'
    ];

    protected $casts = [
        'flag' => 'boolean',
    ];

    public function getValueAttribute($value): mixed
    {
        return match ($this->value_type) {
            'boolean'      => Sanitizer::sanitize($value, 'bool'),
            'integer'      => Sanitizer::sanitize($value, 'int'),
            'float'        => Sanitizer::sanitize($value, 'float'),
            'array'        => Sanitizer::sanitize($value, 'array'),
            'array_bool'   => Sanitizer::sanitize($value, 'array_bool'),
            'array_float'  => Sanitizer::sanitize($value, 'array_float'),
            'array_int'    => Sanitizer::sanitize($value, 'array_int'),
            'array_string' => Sanitizer::sanitize($value, 'array_string'),
            'json'         => Sanitizer::sanitize($value, 'json'),
            'email'        => Sanitizer::sanitize($value, 'email'),
            'html'         => Sanitizer::sanitize($value, 'html'),
            'string'       => Sanitizer::sanitize($value, 'string'),
            'url'          => Sanitizer::sanitize($value, 'url'),
            'message'      => Sanitizer::sanitize($value, 'message'),
            default        => $value,
        };
    }

    public function setValueAttribute($value): void
    {
        $this->attributes['value'] = is_array($value) || is_object($value)
            ? json_encode($value)
            : (string) $value;
    }
}
