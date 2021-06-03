<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface TransactionRepositoryInterface
{
   public function all($columns = ['*']): Collection;
   public function find($id): ?Model;
   public function create(array $attributes): Model;
   public function where(array $attributes): ?Collection;
   public function whereByUser(int $id): ?Model;
}