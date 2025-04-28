<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'version',
        'logo',
        'installed',
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
            $system->name ??= config('app.name');
            $system->version ??= config('app.version', '1.0.0');
            $system->logo ??= config('app.logo', 'images/logo.png');
            $system->installed ??= false;
        });

        static::updating(function ($system) {
            $system->name ??= config('app.name');
            $system->version ??= config('app.version', '1.0.0');
            $system->logo ??= config('app.logo', 'images/logo.png');
            $system->installed ??= false;
        });
    }
}
