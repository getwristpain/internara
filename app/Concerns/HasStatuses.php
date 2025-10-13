<?php

namespace App\Concerns;

use App\Models\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as BaseCollection;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasStatuses
{
    /**
     * Define the polymorph-to-many relationship to the Status model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function statuses(): MorphToMany
    {
        // Include 'expires_at' from the pivot table to handle status expiration.
        return $this->morphToMany(Status::class, 'statusable')
            ->withPivot('expires_at');
    }

    // --------------------------------------------------------------------------
    // QUERY SCOPES
    // --------------------------------------------------------------------------

    /**
     * Scope a query to only include models with the given status(es) and optional type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array<string> $statuses
     * @param string|null $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereStatus(Builder $query, string|array $statuses, ?string $type = null): Builder
    {
        $statuses = Arr::wrap($statuses);

        return $query->whereHas('statuses', function (Builder $q) use ($statuses, $type) {
            $q->whereIn('name', $statuses)
              ->when($type, fn ($subQuery) => $subQuery->where('type', $type));
        });
    }

    /**
     * Scope a query to only include models without the given status(es) and optional type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array<string> $statuses
     * @param string|null $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereNotStatus(Builder $query, string|array $statuses, ?string $type = null): Builder
    {
        $statuses = Arr::wrap($statuses);

        return $query->whereDoesntHave('statuses', function (Builder $q) use ($statuses, $type) {
            $q->whereIn('name', $statuses)
              ->when($type, fn ($subQuery) => $subQuery->where('type', $type));
        });
    }

    // --------------------------------------------------------------------------
    // CHECKERS
    // --------------------------------------------------------------------------

    /**
     * Check if the model has a specific status.
     *
     * @param string $name
     * @param string|null $type
     * @return bool
     */
    public function hasStatus(string $name, ?string $type = null): bool
    {
        return $this->statuses()
            ->where('name', $name)
            ->when($type, fn (Builder $q) => $q->where('type', $type))
            ->exists();
    }

    /**
     * Check if the model's given status is currently expired based on the pivot column 'expires_at'.
     * Returns false if the status is not present or 'expires_at' is null.
     *
     * @param string $name
     * @return bool
     */
    public function hasStatusExpired(string $name): bool
    {
        // Eager load the pivot data if not already present
        $statusModel = $this->statuses()
            ->where('name', $name)
            ->first();

        if (!$statusModel || is_null($statusModel->pivot->expires_at)) {
            return false;
        }

        return Carbon::parse($statusModel->pivot->expires_at)->isPast();
    }

    // --------------------------------------------------------------------------
    // MODIFIERS
    // --------------------------------------------------------------------------

    /**
     * Assign the given status(es) to the model (sync without detaching).
     *
     * @param \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|array<string|int>|string|int $statuses
     * @param string|null $type
     * @return array<string, array<int, int>>
     */
    public function assignStatus(Collection|Model|array|string|int $statuses, ?string $type = null): array
    {
        return $this->syncStatus($statuses, $type, detaching: false);
    }

    /**
     * Assign a single status with an expiration time to the model.
     *
     * @param string|int $status The status name or ID.
     * @param \DateTimeInterface|\DateInterval|int $expiration The expiration time (Carbon instance, DateInterval, or seconds).
     * @param array $attributes Additional pivot attributes.
     * @return array<string, array<int, int>>
     */
    public function assignStatusWithExpiration(string|int $status, $expiration, array $attributes = []): array
    {
        $statusId = is_string($status)
            ? $this->findStatusIdByName($status)
            : $status;

        if (!$statusId) {
            return ['attached' => [], 'detached' => [], 'updated' => []];
        }

        $expiresAt = match (true) {
            $expiration instanceof \DateTimeInterface => $expiration,
            $expiration instanceof \DateInterval => Carbon::now()->add($expiration),
            is_int($expiration) => Carbon::now()->addSeconds($expiration),
            default => null,
        };

        $pivotData = array_merge($attributes, [
            'expires_at' => $expiresAt,
        ]);

        // syncWithoutDetaching is used to only attach or update, not remove other statuses
        return $this->statuses()->syncWithoutDetaching([$statusId => $pivotData]);
    }

    /**
     * Sync the given status(es) to the model.
     *
     * @param \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|array<string|int>|string|int $statuses
     * @param string|null $type
     * @param bool $detaching
     * @return array<string, array<int, int>>
     */
    public function syncStatus(Collection|Model|array|string|int $statuses, ?string $type = null, bool $detaching = true): array
    {
        $ids = $this->resolveStatusIds($statuses, $type);

        return $this->statuses()->sync(
            ids: $ids,
            detaching: $detaching
        );
    }

    /**
     * Remove the given status(es) from the model.
     *
     * @param \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|array<string|int>|string|int $statuses
     * @param string|null $type
     * @return int
     */
    public function removeStatus(Collection|Model|array|string|int $statuses, ?string $type = null): int
    {
        $ids = $this->resolveStatusIds($statuses, $type);

        return $this->statuses()->detach($ids);
    }

    // --------------------------------------------------------------------------
    // INTERNAL HELPERS
    // --------------------------------------------------------------------------

    /**
     * Resolve status input into an array of Status model IDs.
     *
     * @param \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|array<string|int>|string|int $statuses
     * @param string|null $type
     * @return array<int>
     */
    protected function resolveStatusIds(Collection|Model|array|string|int $statuses, ?string $type = null): array
    {
        $statuses = BaseCollection::wrap($statuses);

        $ids = $statuses->map(function ($status) use ($type) {
            if ($status instanceof Model) {
                return $status->getKey();
            }

            if (is_int($status)) {
                return $status;
            }

            // Assume $status is a string (status name), query for the ID.
            if (is_string($status)) {
                return $this->findStatusIdByName($status, $type);
            }

            return null;
        })->filter()->toArray();

        return $ids;
    }

    /**
     * Find the ID of a Status model by its name and optional type.
     *
     * @param string $name
     * @param string|null $type
     * @return int|null
     */
    protected function findStatusIdByName(string $name, ?string $type = null): ?int
    {
        return $this->getStatusQuery($name, $type)->first()?->id;
    }

    /**
     * Get a query builder for finding a Status model by name and optional type.
     *
     * @param string $name
     * @param string|null $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getStatusQuery(string $name, ?string $type = null): Builder
    {
        // Get a fresh query instance for the Status model.
        return Status::query()
            ->where('name', $name)
            ->when($type, fn (Builder $q) => $q->where('type', $type));
    }
}
