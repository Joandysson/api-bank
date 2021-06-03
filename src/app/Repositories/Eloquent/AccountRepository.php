<?php

namespace App\Repositories\Eloquent;

use App\Models\Account;
use App\Repositories\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountRepository extends BaseRepository implements AccountRepositoryInterface
{
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }

    public function whereByUser(int $id): ?Model
    {
        return  $this->model->where(['user_id' => $id])->get()->first();
    }

    public function deposit(int $id, float $value): ?Model
    {
        $account = $this->model->find($id);
        $account->balance = $account->balance + $value;
        $account->save();

        return $account;
    }

    public function withdraw(int $id, float $value): ?Model
    {
        $account = $this->model->find($id);
        $account->balance = $account->balance - $value;
        $account->save();

        return $account;
    }


    public function transfer(int $fromId, int $toId, float $value): ?Model
    {
        try {
            DB::beginTransaction();

            $from = $this->withdraw($fromId, $value);
            $this->deposit($toId, $value);

            DB::commit();

            return $from;
        } catch (\Throwable $th) {
            DB::rollBack();

            return null;
        }

    }

}
