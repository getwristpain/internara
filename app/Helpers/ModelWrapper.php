<?php

namespace App\Helpers;

use App\Helpers\Helper;
use App\Helpers\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelWrapper extends Helper
{
    protected ?Model $model = null;

    protected string $type = 'Record';

    protected array $permissions = [];

    protected array $defaultPermissions = ['create', 'read', 'update', 'delete'];

    /**
     * Class constructor.
     */
    public function __construct(?Model $model = null, ?array $permissions = null)
    {
        $this->model = $model;
        $this->type = class_basename($model);
        $this->permissions = !empty($permissions) ? $permissions : $this->defaultPermissions;
    }

    public function response(): LogicResponse
    {
        return new LogicResponse();
    }

    public function query(): ?Model
    {
        return $this->model;
    }

    public function transaction(callable $callback, int $attempts = 1): mixed
    {
        return DB::transaction($callback, $attempts);
    }

    public function get(array $where = [], array $with = []): Collection|Attribute|null
    {
        if (!$this->isPermitted('read')) {
            $this->response()->failure('The GET method is not permitted.')
            ->withType($this->type)
            ->storeLog();

            return null;
        }

        if ($this->isPermitted('single')) {
            return $this->attributes();
        }

        return $this->model->with($with)->where($where)->get();
    }

    public function attributes(): ?Attribute
    {
        if (!$this->isPermitted('single')) {
            return null;
        }

        return Attribute::make($this->model->first()?->toArray() ?? []);
    }

    public function first(array $where = [], array $with = [], array $default = []): ?Attribute
    {
        if (!$this->isPermitted('read')) {
            $this->response()->failure("The FIRST method is not permitted.")
                ->withType($this->type)
                ->storeLog();

            return null;
        }

        $first = $this->model->with($with)->where($where)->first();

        return Attribute::make($first->toArray() ?? [], $default);
    }

    public function firstOrFail(array $where = [], array $with = [], array $default = []): ?Attribute
    {
        if (!$this->isPermitted('read')) {
            $this->response()->failure("The FIRST or FAIL method is not permitted.")
                ->withType($this->type)
                ->storeLog();

            return null;
        }

        $first = $this->model->with($with)->where($where)->firstOrFail();

        return Attribute::make($first->toArray() ?? [], $default);
    }

    public function firstOrCreate(array $attributes = [], array $values = [], array $with = [], array $default = []): ?Attribute
    {
        if (!$this->isPermitted(['read', 'create'])) {
            $this->response()->failure("The FIRST or CREATE method is not permitted.")
                ->withType($this->type)
                ->storeLog();

            return null;
        }

        $first = $this->model->with($with)->firstOrCreate($attributes, $values);

        return Attribute::make($first->toArray() ?? [], $default);
    }

    public function set(array $attributes): LogicResponse
    {
        if (!$this->isPermitted(['single', 'update']) || empty($attributes)) {
            return $this->response()->failure('The SET method is not permitted.')
                ->withType($this->type)
                ->storeLog();
        }

        $first = $this->first();

        if (empty($first)) {
            if (!$this->isPermitted('create')) {
                return $this->response()->failure("{$this->type} not found.")
                    ->withType($this->type)
                    ->storeLog();
            }

            return $this->create($attributes);
        }

        return $this->update(['id' => $first->id], $attributes);
    }

    public function create(array $attributes): LogicResponse
    {
        if (empty($attributes) || !$this->isPermitted('create')) {
            return $this->response()->failure("The CREATE method is not permitted.")
                ->withType($this->type);
        }

        if ($this->isPermitted('single')) {
            $ensureSingle = $this->model->all()->count() < 2 ? true : false;

            if (!$ensureSingle) {
                return $this->response()->failure("Only one {$this->type} is allowed.")
                    ->withType($this->type);
            }
        }

        $model = $this->model->create($attributes);

        if (!$model) {
            return $this->response()->failure("{$this->type} is failed to create.")
                ->withType($this->type);
        }

        return $this->response()->success("{$this->type} has been created successfully.")
            ->withType($this->type)
            ->withStatus('created')
            ->withPayload($model?->toArray())
            ->operator($model);
    }

    public function insert(array $data = []): LogicResponse
    {
        if (!$this->isPermitted('create') || $this->isPermitted('single')) {
            return $this->response()->failure("The INSERT method is not permitted.");
        }

        $model = $this->model->insert($data);

        if (!$model) {
            return $this->response()->failure("Failed to insert {$this->type} data.")
                ->withType($this->type);
        }

        return $this->response()->success("{$this->type} data are inserted successfully.")
            ->withStatus('created');
    }

    public function update(array $where, array $attributes): LogicResponse
    {
        if (empty($where) || empty($attributes) || !$this->isPermitted('update')) {
            return $this->response()->failure("The UPDATE method is not permitted.")
                ->withType($this->type);
        }

        $model = $this->model->where($where)->update($attributes);

        if (!$model) {
            return $this->response()->failure("{$this->type} is failed to update.")
                ->withType($this->type);
        }

        return $this->response()->success("{$this->type} has been updated successfully.")
            ->withType($this->type)
            ->withStatus('updated');
    }

    public function updateOrCreate(array $where, array $attributes): LogicResponse
    {
        $model = $this->update($where, $attributes);

        if ($model->fails()) {
            return $this->create($attributes);
        }

        return $model;
    }

    public function delete(string $column, mixed $values): LogicResponse
    {
        if (empty($column) || empty($values) || !$this->isPermitted('delete')) {
            return $this->response()->failure("The DELETE method is not permitted.")
                ->withType($this->type);
        }

        $model = $this->model->whereIn($column, $values)->delete();

        if (!$model) {
            return $this->response()->failure("{$this->type} is failed to delete.")
                ->withType($this->type);
        }

        return $this->response()->success("{$this->type} has been deleted successfully.")
            ->withType($this->type)
            ->withStatus('deleted');
    }

    public function deleleByIds(int|string|array $ids): LogicResponse
    {
        return $this->delete('id', $ids);
    }

    protected function isPermitted(string|array $required): bool
    {
        $required = is_string($required) ? [$required] : $required;
        $missing = array_diff($required, $this->permissions);

        return empty($missing) ? true : false;
    }
}
