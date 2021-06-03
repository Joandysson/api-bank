<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Boolean;

interface UserRepositoryInterface
{

   public function all($columns = ['*']): Collection;
   public function find($id): ?Model;
   public function create(array $attributes): Model;
   public function where(array $attributes): ?Model;
   public function update(array $attributes = [], array $options = []): bool;
   public function delete(): bool|null;
   public function save(array $attributes, array $options = []): Model;
   public function createOrUpdate(array $attributes, ?int $id = null): bool;
}