<?php

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements EloquentRepositoryInterface
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function where(array $attributes): ?Collection
    {
        return  $this->model->where($attributes)->get();
    }

    public function all($columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    public function update(array $attributes = [], array $options = []): bool
    {
        return $this->model->update($attributes, $options);
    }

    public function delete(): bool|null
    {
        return $this->model->delete();
    }
}
