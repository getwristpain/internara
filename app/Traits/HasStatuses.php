<?php

namespace App\Traits;

use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
* @mixin \Illuminate\Database\Eloquent\Model
*/
trait HasStatuses
{
    public function statuses(): MorphToMany
    {
        return $this->morphToMany(Status::class, 'statusable')
            ->withTimestamps();
    }

    public function syncStatuses(Collection|Model|array|int|string $statuses, string|null $type = null, bool $detaching = true): array
    {
        $ids = collect($statuses)
            ->map(
                function ($status) use ($type) {
                    if ($status instanceof Model) {
                        return $status->id;
                    }

                    if (is_numeric($status)) {
                        return $status;
                    }

                    return Status::query()
                        ->when($type !== null, fn ($q) => $q->where('type', $type))
                        ->firstOrCreate(['name' => $status])
                        ->id;
                }
            )->all();

        return $this->statuses()
            ->sync($ids, $detaching);
    }

    public function hasStatuses(Collection|Model|string|int|array $statuses, string|null $type = null): Collection
    {
        $ids = collect($statuses)
            ->map(
                function ($status) use ($type) {
                    if ($status instanceof Model) {
                        return $status->id;
                    }

                    if (is_numeric($status)) {
                        return $status;
                    }

                    return Status::where('name', $status)
                        ->when($type !== null, fn ($q) => $q->where('type', $type))
                        ->value('id');
                }
            )
            ->filter()
            ->all();

        return static::whereHas('statuses', fn ($q)
            => $q->whereIn('statuses.id', $ids))
        ->get();
    }
}
