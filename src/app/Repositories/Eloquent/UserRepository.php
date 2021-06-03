<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function createOrUpdate(array $attributes, ?int $id = null): bool|Model
    {
        if ($id) {
            $modelData = $this->model->find($id);

            $modelData->name = $attributes['name'] ? $attributes['name'] : $modelData['name'];
            $modelData->email = $attributes['email'] ? $attributes['email'] : $modelData['email'];
            $modelData->cpf_cnpj = $attributes['cpf_cnpj'] ? $attributes['cpf_cnpj'] : $modelData['cpf_cnpj'];
            $modelData->password = $attributes['password'] ? $attributes['password'] : $modelData['password'];

            return $modelData->save();
        }

        return $this->save($attributes);
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
