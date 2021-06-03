<?php
namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
* Interface EloquentRepositoryInterface
* @package App\Repositories
*/
interface EloquentRepositoryInterface
{
   public function create(array $attributes): Model;

   public function find($id): ?Model;

   public function where(array $attributes): ?Collection;

}
