<?php

namespace App\Models;

use App\Helpers\Sanitizer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'label',
        'category',
        'description',
    ];

    public function getValueAttribute($value): mixed
    {
        return match ($this->type) {
            'array_bool'   => Sanitizer::sanitize($value, 'array_bool'),
            'array_float'  => Sanitizer::sanitize($value, 'array_float'),
            'array_int'    => Sanitizer::sanitize($value, 'array_int'),
            'array_string' => Sanitizer::sanitize($value, 'array_string'),
            'array'        => Sanitizer::sanitize($value, 'array'),
            'boolean'      => Sanitizer::sanitize($value, 'bool'),
            'email'        => Sanitizer::sanitize($value, 'email'),
            'float'        => Sanitizer::sanitize($value, 'float'),
            'html'         => Sanitizer::sanitize($value, 'html'),
            'integer'      => Sanitizer::sanitize($value, 'int'),
            'json'         => Sanitizer::sanitize($value, 'json'),
            'message'      => Sanitizer::sanitize($value, 'message'),
            'string'       => Sanitizer::sanitize($value, 'string'),
            'url'          => Sanitizer::sanitize($value, 'url'),
            default        => $value,
        };
    }

    public function setKeyAttribute($value): void
    {
        $this->attributes['key'] = strtolower(trim($value));
    }

    public function setValueAttribute($value): void
    {
        $this->attributes['value'] = is_array($value) || is_object($value)
            ? json_encode($value)
            : (string) $value;
    }
}
