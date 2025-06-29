<?php

namespace App\Helpers;

use App\Contracts\EntityContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Wrapper for Eloquent model operations with response helpers.
 */
class ModelWrapper extends Helper implements EntityContract
{
    /**
     * The Eloquent model instance.
     *
     * @var Model|null
     */
    protected ?Model $model = null;

    /**
     * The model class name.
     *
     * @var string
     */
    protected string $modelClass = '';

    /**
     * The type name for response.
     *
     * @var string
     */
    protected string $type = 'Record';

    /**
     * ModelWrapper constructor.
     *
     * @param Model|null $model
     */
    public function __construct(?Model $model = null)
    {
        $this->setModel($model);
    }

    /**
     * Get a new model query instance.
     *
     * @return Model|null
     */
    public function query(): ?Model
    {
        return $this->modelClass ? app($this->modelClass) : null;
    }

    /**
     * Get the current model instance.
     *
     * @return Model|null
     */
    public function instance(): ?Model
    {
        return $this->model;
    }

    /**
     * Get all records.
     *
     * @param array|string $columns
     * @param array $with
     * @return Collection|null
     */
    public function all(array|string $columns = ['*'], array $with = []): ?Collection
    {
        if (!empty($with)) {
            return $this->get(with: $with);
        }

        return $this->model
            ? $this->query()?->all($columns) ?? new Collection([])
            : null;
    }

    /**
     * Get records by where condition.
     *
     * @param array $where
     * @param array $with
     * @param array|string $columns
     * @return Collection|null
     */
    public function get(array $where = [], array $with = [], array|string $columns = ['*']): ?Collection
    {
        return $this->model
            ? $this->query()?->with($with)->where($where)->get($columns) ?? new Collection([])
            : null;
    }

    /**
     * Find a record by id.
     *
     * @param mixed $id
     * @param array $with
     * @return Collection|Model|null
     */
    public function find(mixed $id, array $with = []): Collection|Model|null
    {
        return $this->model
            ? $this->query()?->with($with)->find($id)
            : null;
    }

    /**
     * Get the first record by where condition.
     *
     * @param array $where
     * @param array $with
     * @return Model|null
     */
    public function first(array $where = [], array $with = []): ?Model
    {
        return $this->model
            ? $this->query()?->with($with)->where($where)->first()
            : null;
    }

    /**
     * Get the first record or fail by where condition.
     *
     * @param array $where
     * @param array $with
     * @return Model|null
     */
    public function firstOrFail(array $where = [], array $with = []): ?Model
    {
        return $this->model
            ? $this->query()?->with($with)->where($where)->firstOrFail()
            : null;
    }

    /**
     * Get the first record or create a new one.
     *
     * @param array $where
     * @param array $attributes
     * @param array $with
     * @return Model|null
     */
    public function firstOrCreate(array $where = [], array $attributes = [], array $with = []): ?Model
    {
        return $this->model
            ? $this->query()?->with($with)->firstOrCreate($where, $this->filterFillable($attributes))
            : null;
    }

    /**
     * Create a new record.
     *
     * @param array $attributes
     * @return LogicResponse
     */
    public function create(array $attributes = []): LogicResponse
    {
        try {
            $model = $this->query()?->create($this->filterFillable($attributes));
            $this->setModel($model);

            return $this->response()
                ->success('messages.success.created', ['resource' => $this->type]);
        } catch (\Throwable $e) {
            return $this->response()
                ->failure('messages.error.create_failed', ['resource' => $this->type])
                ->debug($e);
        }
    }

    /**
     * Insert multiple rows.
     *
     * @param array $rows
     * @return LogicResponse
     */
    public function insert(array $rows): LogicResponse
    {
        try {
            $this->query()?->insert(array_map(fn ($row) => $this->filterFillable($row), $rows));

            return $this->response()
                ->success('messages.success.stored', ['resource' => $this->type]);
        } catch (\Throwable $e) {
            return $this->response()
                ->failure('messages.error.store_failed', ['resource' => $this->type])
                ->debug($e);
        }
    }

    /**
     * Update records by where condition.
     *
     * @param array $attributes
     * @param array $where
     * @return LogicResponse
     */
    public function update(array $attributes = [], array $where = []): LogicResponse
    {
        try {
            $query = $this->query()?->newQuery();
            if ($where) {
                $query->where($where);
            }
            $query->update($this->filterFillable($attributes));
            return $this->response()->success('messages.success.updated', ['resource' => $this->type]);
        } catch (\Throwable $e) {
            return $this->response()
                ->failure('messages.error.update_failed', ['resource' => $this->type])
                ->debug($e);
        }
    }

    /**
     * Update a record if exists, otherwise create it.
     *
     * @param array $where
     * @param array $attributes
     * @return LogicResponse
     */
    public function updateOrCreate(array $where = [], array $attributes = []): LogicResponse
    {
        try {
            $model = $this->query()?->updateOrCreate(
                $where,
                $this->filterFillable($attributes)
            );
            $this->setModel($model);

            return $this->response()
                ->success('messages.success.saved', ['resource' => $this->type]);
        } catch (\Throwable $e) {
            return $this->response()
                ->failure('messages.error.save_failed', ['resource' => $this->type])
                ->debug($e);
        }
    }

    /**
     * Delete a record by id.
     *
     * @param mixed $id
     * @return LogicResponse
     */
    public function delete(mixed $id): LogicResponse
    {
        try {
            $this->query()?->destroy($id);
            return $this->response()->success('messages.success.deleted', ['resource' => $this->type]);
        } catch (\Throwable $e) {
            return $this->response()
                ->failure('messages.error.delete_failed', ['resource' => $this->type])
                ->debug($e);
        }
    }

    /**
     * Delete multiple records by ids.
     *
     * @param array $ids
     * @return LogicResponse
     */
    public function destroy(array $ids): LogicResponse
    {
        try {
            $this->query()?->destroy($ids);
            return $this->response()->success('messages.success.deleted', ['resource' => $this->type]);
        } catch (\Throwable $e) {
            return $this->response()
                ->failure('messages.error.delete_failed', ['resource' => $this->type])
                ->debug($e);
        }
    }

    /**
     * Convert the model to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->model?->toArray() ?? [];
    }

    /**
     * Convert the model to attributes.
     *
     * @return Attribute
     */
    public function toAttributes(): Attribute
    {
        return Attribute::make($this->model?->toArray() ?? []);
    }

    /**
     * Convert the model to collection.
     *
     * @return Collection
     */
    public function toCollection(): Collection
    {
        $data = $this->model?->toArray() ?? [];

        return Support::isFlatAssocArray($data)
            ? Collection::make($data)
            : Collection::make([$data]);
    }

    /**
     * Get a LogicResponse for this wrapper.
     *
     * @return LogicResponse
     */
    public function response(): LogicResponse
    {
        return (new LogicResponse())
            ->withType($this->type)
            ->withPayload($this->toArray())
            ->operator($this);
    }

    /**
     * Filter attributes by model fillable.
     *
     * @param array $attributes
     * @return array
     */
    protected function filterFillable(array $attributes): array
    {
        return Support::filter($attributes, $this->model?->getFillable() ?? []);
    }

    /**
     * Set the model and update related properties.
     *
     * @param Model|null $model
     * @return static
     */
    protected function setModel(?Model $model): static
    {
        $this->model = $model;
        $this->modelClass = $model ? get_class($model) : '';
        $this->type = $model ? class_basename($model) : $this->type;

        return $this;
    }
}
