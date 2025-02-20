<?php

namespace App\Services;

use Closure;
use App\Debugger;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Service
{
    use Debugger;

    protected array $attributes = [];
    protected ?Model $model;
    protected string $cacheKey;
    protected int $cacheTTL;

    public function __construct(?Model $model = null, int $cacheTTL = 60)
    {
        $this->model = $model;
        $this->cacheKey = Str::lower(class_basename($model));
        $this->cacheTTL = $cacheTTL;
    }

    public function __set(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function getAll(): Collection
    {
        return $this->queryCached(fn($model) => $model->all(), 'all');
    }

    public function getWhere(array $where, array $with = []): Collection
    {
        return $this->queryCached(fn($model) => $model->with($with)->where($where)->get(), 'find_all', $where);
    }

    public function first(): ?Model
    {
        return $this->queryCached(fn($model) => $model->first(), 'first');
    }

    public function find(string|int $id, array $with = []): ?Model
    {
        return $this->queryCached(fn($model) => $model->with($with)->find($id), 'id', ['id' => $id]);
    }

    public function firstWhere(array $where, array $with = []): ?Model
    {
        return $this->queryCached(fn($model) => $model->with($with)->where($where)->first(), 'find_one', $where);
    }

    public function create(array $data): Model
    {
        $validatedData = $this->validate($data);
        return $this->model->create($validatedData);
    }

    public function update(string|int $id, array $data): Model
    {
        $this->attributes['id'] = $id;
        $validatedData = $this->validate($data);

        $model = $this->find($id);
        if ($model->update($validatedData)) {
            Cache::forget($this->generateCacheKey('id', ['id' => $id]));
        }

        return $model;
    }

    public function delete(string|int $id): bool
    {
        $model = $this->find($id);
        if ($model->delete()) {
            Cache::forget($this->generateCacheKey('id', ['id' => $id]));
        }

        return true;
    }

    public function forceDelete(string|int $id): bool
    {
        $model = $this->find($id);
        if ($model->forceDelete()) {
            Cache::forget($this->generateCacheKey('id', ['id' => $id]));
        }

        return true;
    }

    public function restore(string|int $id): bool
    {
        $model = $this->find($id);
        if ($model->restore()) {
            Cache::forget($this->generateCacheKey('id', ['id' => $id]));
        }

        return true;
    }

    public function updateOrCreate(array $where, array $data): Model
    {
        if (isset($where['id'])) {
            $this->attributes['id'] = $where['id'];
        }
        $validatedData = $this->validate($data);
        $model = $this->model->updateOrCreate($where, $validatedData);
        Cache::forget($this->generateCacheKey('id', ['id' => $model->id]));

        return $model;
    }

    public function bulkAction(array $ids, string $action, array $attributes = []): void
    {
        $query = $this->model->whereIn('id', $ids);

        switch ($action) {
            case 'insert':
                $validatedData = array_map(fn($item) => $this->validate($item), $attributes);
                $this->model->insert($validatedData);
                break;
            case 'upsert':
                $validatedData = array_map(fn($item) => $this->validate($item), $attributes);
                $this->model->upsert($validatedData, ['id']);
                break;
            case 'update':
                $validatedData = $this->validate($attributes);
                $query->update($validatedData);
                break;
            case 'delete':
                $query->delete();
                break;
            case 'restore':
                $query->restore();
                break;
            case 'forceDelete':
                $query->forceDelete();
                break;
            default:
                $query->$action();
                break;
        }
    }

    protected function queryCached(Closure $callback, string $key, array $filters = [])
    {
        $cacheKey = $this->generateCacheKey($key, $filters);
        return Cache::remember($cacheKey, $this->cacheTTL, fn() => $callback($this->model));
    }

    private function generateCacheKey(string $key, array $filters = []): string
    {
        $cacheFilters = empty($filters) ? '' : md5(serialize($filters));
        return implode(':', [$this->cacheKey, $key, $cacheFilters]);
    }

    public function transaction(Closure $callback)
    {
        return $this->model->getConnection()->transaction($callback);
    }

    protected function rules(): array
    {
        return [];
    }

    protected function validate(array $data = [], array $rules = [], array $messages = [], array $attributes = []): array
    {
        $data = array_merge($this->attributes, $data);
        $rules = array_merge($this->rules(), $rules);
        return validator($data, $rules, $messages, $attributes)->validate();
    }
}
