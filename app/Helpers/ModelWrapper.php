<?php

namespace App\Helpers;

use App\Contracts\EntityContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class ModelWrapper extends Helper implements EntityContract
{
    protected Model|Builder|null $model;

    protected string $modelClass = '';

    protected string $type = 'Record';

    protected array $meta = [];

    public function __construct(Model|Builder|null $model = null)
    {
        $this->setModel($model);
    }

    public function withMeta(array $meta = []): static
    {
        $this->meta = array_merge($this->meta, $meta);
        return $this;
    }

    public function query(): Model|null
    {
        return !empty($this->modelClass) ? app($this->modelClass) : null;
    }

    public function instance(): Model|Builder|null
    {
        return $this->model ?? null;
    }

    public function all(array|string $column = '[*]'): ?Collection
    {
        if (!$this->model) {
            return null;
        }

        $query = $this->query()->all($column);
        $this->withMeta(['count' => $query->count() ?? 0]);

        return $query ?? new Collection([]);
    }

    public function get(array $where = [], array $with = [], array|string $column = '[*]'): ?Collection
    {
        if (!$this->model) {
            return null;
        }

        $query = $this->query()->with($with)
            ->where($where)
            ->get($column);

        $this->withMeta(['count' => $query->count() ?? 0]);

        return $query ?? new Collection([]);
    }

    public function find($id, array $with = []): Collection|Model|null
    {
        if (!$this->model) {
            return null;
        }

        $query = $this->query()->with($with)
            ->find($id);

        $this->withMeta(['found' => $query ? 1 : 0]);

        return $query;
    }

    public function first(array $where = [], array $with = []): ?Model
    {
        if (!$this->model) {
            return null;
        }

        $query = $this->query()->with($with)
            ->where($where)
            ->first();

        $this->withMeta(['found' => $query ? 1 : 0]);

        return $query;
    }

    public function firstOrFail(array $where = [], array $with = []): ?Model
    {
        if (!$this->model) {
            return null;
        }

        $query = $this->query()->with($with)
            ->where($where)
            ->firstOrFail();

        $this->withMeta(['found' => $query ? 1 : 0]);

        return $query;
    }

    public function firstOrCreate(array $where = [], array $attributes = [], array $with = []): ?Model
    {
        if (!$this->model) {
            return null;
        }

        $query = $this->query()->with($with)
            ->firstOrCreate($where, $this->filterFillable($attributes));
        $this->withMeta(['created' => $query->wasRecentlyCreated ? 1 : 0]);

        return $query;
    }

    public function create(array $attributes = []): LogicResponse
    {
        try {
            $model = $this->query()->create($this->filterFillable($attributes));
            $this->setModel($model)->withMeta(['created' => $model ? 1 : 0]);

            return $this->response()->success('Data created successfully.');
        } catch (\Throwable $e) {
            return $this->response()->failure('Failed to create data: ' . $e->getMessage())->debug($e);
        }
    }

    public function insert(array $rows): LogicResponse
    {
        try {
            $fillableRows = array_map(fn ($row) => $this->filterFillable($row), $rows);
            $result = $this->query()->insert($fillableRows);
            $this->withMeta([
                'inserted' => $result ? 1 : 0,
                'saved_count' => $result ? count($fillableRows) : 0
            ]);
            return $this->response()->success('Data inserted successfully.');
        } catch (\Throwable $e) {
            return $this->response()->failure('Failed to insert data: ' . $e->getMessage())->debug($e);
        }
    }

    public function update(array $attributes = [], array $where = []): LogicResponse
    {
        try {
            $query = $this->query()->newQuery();
            if ($where) {
                $query->where($where);
            }
            $updated = $query->update($this->filterFillable($attributes));
            $this->withMeta(['updated' => $updated]);
            return $this->response()->success('Data updated successfully.');
        } catch (\Throwable $e) {
            return $this->response()->failure('Failed to update data: ' . $e->getMessage())->debug($e);
        }
    }

    public function delete($id): LogicResponse
    {
        try {
            $deleted = $this->query()->destroy($id);
            $this->withMeta(['deleted' => $deleted]);
            return $this->response()->success('Data deleted successfully.');
        } catch (\Throwable $e) {
            return $this->response()->failure('Failed to delete data: ' . $e->getMessage())->debug($e);
        }
    }

    public function destroy(array $ids): LogicResponse
    {
        try {
            $deleted = $this->query()->destroy($ids);
            $this->withMeta(['deleted' => $deleted]);
            return $this->response()->success('Data deleted successfully.');
        } catch (\Throwable $e) {
            return $this->response()->failure('Failed to delete data: ' . $e->getMessage())->debug($e);
        }
    }

    public function toArray(): array
    {
        return [
            'data' => $this->model?->toArray() ?? [],
            'meta' => $this->meta
        ];
    }

    public function toAttributes(): Attribute
    {
        return Attribute::make($this->model?->toArray() ?? []);
    }

    public function toCollection(): Collection
    {
        $data = $this->model?->toArray() ?? [];

        if (!ArrayHelper::isFlatAssoc($data)) {
            return Collection::make([$data]);
        }

        return Collection::make($data);
    }

    public function response(): LogicResponse
    {
        $response = new LogicResponse();

        return $response
            ->withType($this->type)
            ->withPayload($this->toArray())
            ->operator($this);
    }

    protected function filterFillable(array $attributes): array
    {
        return Helper::filter($attributes, $this->model->getFillable());
    }

    protected function setmodel(Model|Builder|null $model): static
    {
        $this->model = $model;
        $this->modelClass = $model ? get_class($model) : '';
        $this->type = $model ? class_basename($model) : $this->type;

        return $this;
    }
}
