<?php

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BaseRepository implements EloquentRepositoryInterface
{
    public function __construct(protected Model $model)
    {
        //
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

    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }
    public function commit(): void
    {
        DB::commit();
    }
    public function rollBack(): void
    {
        DB::rollBack();
    }




}
