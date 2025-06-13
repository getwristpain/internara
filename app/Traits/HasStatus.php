<?php

namespace App\Traits;

use App\Models\Status;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasStatus
{
    public static function bootHasStatus(): void
    {
        static::created(function ($model) {
            if (property_exists($model, 'statuses')) {
                foreach ($model->statuses as $type => $statuses) {
                    foreach ($statuses as $status) {
                        $created = Status::updateOrCreate(array_merge($status, [
                            'type' => is_string($type) ? $type : '',
                        ]));

                        $model->statusables()->syncWithoutDetaching($created);
                    }
                }
            }
        });
    }

    public function statusables(): MorphToMany
    {
        return $this->morphToMany(Status::class, 'statusable')->withTimestamps();
    }
}
