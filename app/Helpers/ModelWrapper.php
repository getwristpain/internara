<?php

namespace App\Helpers;

use Closure;
use App\Contracts\EntityContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ModelWrapper
 *
 * Wraps Eloquent model operations and standardizes the response format.
 */
class ModelWrapper extends Helper implements EntityContract
{
    /**
     * The current model instance.
     *
     * @var Model|null
     */
    protected ?Model $model = null;

    /**
     * The class name of the model.
     *
     * @var string
     */
    protected string $modelClass = '';

    /**
     * Type name used in response messages.
     *
     * @var string
     */
    protected string $type = 'Data';

    /**
     * Make ModelWrapper instance.
     * @param Model|null $model
     *
     * @return static
     */
    public static function make(?Model $model = null): static
    {
        $instance = new static();
        $instance->setModel($model);
        return $instance;
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
     * Get all model records.
     *
     * @param array|string $columns
     * @param array $with
     * @return Collection|null
     */
    public function all(array|string $columns = ['*'], array $with = []): ?Collection
    {
        return !empty($with)
            ? $this->get(with: $with)
            : $this->query()?->all($columns) ?? new Collection([]);
    }

    /**
     * Get model records by criteria.
     *
     * @param array $where
     * @param array $with
     * @param array|string $columns
     * @return Collection|null
     */
    public function get(array $where = [], array $with = [], array|string $columns = ['*']): ?Collection
    {
        return $this->query()?->with($with)->where($where)->get($columns) ?? new Collection([]);
    }

    /**
     * Find a record by primary key.
     *
     * @param mixed $id
     * @param array $with
     * @return Model|Collection|null
     */
    public function find(mixed $id, array $with = []): Model|Collection|null
    {
        return $this->query()?->with($with)->find($id);
    }

    /**
     * Get the first record matching the criteria.
     *
     * @param array $where
     * @param array $with
     * @return Model|null
     */
    public function first(array $where = [], array $with = []): ?Model
    {
        return $this->query()?->with($with)->where($where)->first();
    }

    /**
     * Get the first record or fail if not found.
     *
     * @param array $where
     * @param array $with
     * @return Model|null
     */
    public function firstOrFail(array $where = [], array $with = []): ?Model
    {
        return $this->query()?->with($with)->where($where)->firstOrFail();
    }

    /**
     * Get the first record or create it.
     *
     * @param array $where
     * @param array $attributes
     * @param array $with
     * @return Model|null
     */
    public function firstOrCreate(array $where = [], array $attributes = [], array $with = []): ?Model
    {
        return $this->query()?->with($with)->firstOrCreate($where, $this->filterFillable($attributes));
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
            return $this->response()->success("{$this->type} berhasil dibuat.");
        } catch (\Throwable $e) {
            return $this->response()->failure("Gagal membuat {$this->type}.")->debug($e);
        }
    }

    /**
     * Insert multiple records.
     *
     * @param array $rows
     * @return LogicResponse
     */
    public function insert(array $rows): LogicResponse
    {
        try {
            $this->query()?->insert(array_map(fn ($row) => $this->filterFillable($row), $rows));
            return $this->response()->success("Semua {$this->type} berhasil disimpan.");
        } catch (\Throwable $e) {
            return $this->response()->failure("Gagal menyimpan {$this->type}.")->debug($e);
        }
    }

    /**
     * Update records matching criteria.
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
            return $this->response()->success("{$this->type} berhasil diperbarui.");
        } catch (\Throwable $e) {
            return $this->response()->failure("Gagal memperbarui {$this->type}.")->debug($e);
        }
    }

    /**
     * Update existing record or create a new one.
     *
     * @param array $where
     * @param array $attributes
     * @return LogicResponse
     */
    public function updateOrCreate(array $where = [], array $attributes = []): LogicResponse
    {
        try {
            $model = $this->query()?->updateOrCreate($where, $this->filterFillable($attributes));
            $this->setModel($model);
            return $this->response()->success("{$this->type} berhasil diperbarui atau dibuat.");
        } catch (\Throwable $e) {
            return $this->response()->failure("Gagal memperbarui atau membuat {$this->type}.")->debug($e);
        }
    }

    /**
     * Delete a record by ID.
     *
     * @param mixed $id
     * @return LogicResponse
     */
    public function delete(mixed $id): LogicResponse
    {
        try {
            $this->query()?->destroy($id);
            return $this->response()->success("{$this->type} berhasil dihapus.");
        } catch (\Throwable $e) {
            return $this->response()->failure("Gagal menghapus {$this->type}.")->debug($e);
        }
    }

    /**
     * Delete multiple records.
     *
     * @param array $ids
     * @return LogicResponse
     */
    public function destroy(array $ids): LogicResponse
    {
        try {
            $this->query()?->destroy($ids);
            return $this->response()->success("Semua {$this->type} berhasil dihapus.");
        } catch (\Throwable $e) {
            return $this->response()->failure("Gagal menghapus beberapa {$this->type}.")->debug($e);
        }
    }

    /**
     * Run the given closure within a transaction.
     *
     * @param Closure $callback
     * @param int $attempts
     * @return mixed
     */
    public function transaction(Closure $callback, int $attempts = 1): mixed
    {
        return DB::transaction($callback, $attempts);
    }

    /**
     * Get model as array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->model?->toArray() ?? [];
    }

    /**
     * Get model as attributes.
     *
     * @return Attribute
     */
    public function toAttributes(): Attribute
    {
        return Attribute::make($this->toArray());
    }

    /**
     * Get model as collection.
     *
     * @return Collection
     */
    public function toCollection(): Collection
    {
        $data = $this->toArray();
        return Support::isFlatAssocArray($data)
            ? Collection::make($data)
            : Collection::make([$data]);
    }

    /**
     * Get LogicResponse instance with context.
     *
     * @return LogicResponse
     */
    public function response(): LogicResponse
    {
        return LogicResponse::make()
            ->withType($this->type)
            ->withPayload($this->toArray())
            ->operator($this);
    }

    /**
     * Filter only fillable attributes.
     *
     * @param array $attributes
     * @return array
     */
    protected function filterFillable(array $attributes): array
    {
        return Support::filter($attributes, $this->model?->getFillable() ?? []);
    }

    /**
     * Set model and related meta.
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
