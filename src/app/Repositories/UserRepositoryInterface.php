<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{

   public function all(): Collection;
   public function create(array $attributes): Model;

}