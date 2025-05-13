<?php

namespace App\Models;

use App\Helpers\Formatter;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'label',
        'description',
        'priority',
        'color',
        'icon',
        'is_active',
        'is_default',
    ];

    public function setAttribute($key, $value)
    {
        if ($key === 'name' || $key === 'type') {
            $value = Formatter::snakecase($value);
        }

        return parent::setAttribute($key, $value);
    }
}
