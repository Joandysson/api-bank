<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface AccountRepositoryInterface
{
   public function all($columns = ['*']): Collection;
   public function find($id): ?Model;
   public function create(array $attributes): Model;
   public function where(array $attributes): ?Collection;
   public function whereByUser(int $id): ?Model;
   public function deposit(int $id, float $value): ?Model;
   public function withdraw(int $id, float $value): ?Model;
   public function transfer(int $fromId, int $toId, float $value): ?Model;
   public function update(array $attributes = [], array $options = []): bool;
   public function delete(): bool|null;

   public function beginTransaction(): void;
   public function commit(): void;
   public function rollBack(): void;
}