<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'name',
        'logo',
        'installed'
    ];

    /**
     * Boot the model.
     *
     * This method is called when the model is initialized.
     * It registers the creating event listener to set default values for name and logo.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($system) {
            $system->name = $system->name ?? config('app.name');
            $system->logo = $system->logo ?? asset('images/logo.png');
        });
    }
}
