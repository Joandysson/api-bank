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

    public function createOrUpdate(array $attributes, ?int $id = null): bool
    {
        if($id) {
            $modelData = $this->model->find($id);

            $modelData->name = $attributes['name'] ? $attributes['name'] : $modelData['name'];
            $modelData->email = $attributes['email'] ? $attributes['email'] : $modelData['email'];
            $modelData->cpf_cnpj = $attributes['cpf_cnpj'] ? $attributes['cpf_cnpj'] : $modelData['cpf_cnpj'];
            $modelData->password = $attributes['password'] ? $attributes['password'] : $modelData['password'];

            return $modelData->save();
        }

        return $this->save($attributes);
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function where(array $attributes): ?Model
    {
        return $this->model->where($attributes);
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

    public function save(array $attributes, array $options = []): Model
    {
        $this->model->name = $attributes['name'];
        $this->model->email = $attributes['email'];
        $this->model->cpf_cnpj = $attributes['cpf_cnpj'];
        $this->model->password = $attributes['password'];
        $this->model->save($options);

        return $this->model;
    }
}
