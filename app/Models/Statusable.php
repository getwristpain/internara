<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statusable extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'statusable_id' => 'string',
        ];
    }
}
