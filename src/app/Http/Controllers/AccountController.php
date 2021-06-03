<?php

namespace App\Http\Controllers;

use App\Repositories\AccountRepositoryInterface;
use App\Repositories\Eloquent\TransactionRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $account;
    protected $user;
    protected $transaction;

    public function __construct(
        UserRepositoryInterface $user,
        AccountRepositoryInterface $account,
        TransactionRepository $transaction
    ) {
        $this->user = $user;
        $this->account = $account;
        $this->transaction = $transaction;
    }

    function index()
    {
        return response()->json($this->account->all());
    }

    function store(Request $request)
    {
        $this->validate($request, ['user_id' => 'required|integer']);
        $userData = $this->user->find($request->user_id);
        if (!$userData) return response()->json(['message' => 'user not found'], 404);

        $accountData = $this->account->where(['user_id' => $request->user_id]);

        if (!empty($accountData->all())) return response()->json(['message' => 'already registered user'], 409);

        try {
            $account = $this->account->create($request->all());

            return response()->json($account, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    function deposit(Request $request)
    {
        $this->validate($request, ['value' => 'required|numeric|min:0.01', 'account_id' => 'required|integer']);
        $accountData = $this->account->find($request->account_id);

        if (!$accountData) return response()->json(['message' => 'account not found'], 404);

        $account = $this->account->deposit($request->account_id, $request->value);
        $this->transaction->create([
            'account_id' => $request->account_id,
            'value' => $request->value
        ]);


        return response()->json($account);
    }

    function withdraw(Request $request)
    {
        $this->validate($request, ['value' => 'required|numeric|min:0.01', 'account_id' => 'required|integer']);
        $accountData = $this->account->find($request->account_id);

        if (!$accountData) return response()->json(['message' => 'account not found'], 404);

        if ($accountData->balance < $request->value) return response()->json(['message' => 'insufficient funds'], 401);

        $account = $this->account->withdraw($request->account_id, $request->value);
        $this->transaction->create([
            'account_id' => $request->account_id,
            'value' => -$request->value
        ]);

        return response()->json($account);
    }

    function transfer(Request $request)
    {
        $this->validate($request, [
            'account' => 'required|integer',
            'account_to' => 'required|integer',
            'value' => 'required|numeric|min:0.01'
        ]);

        if ($request->account == $request->account_to) {
            return response()->json(['message' => 'It was not possible to make a transfer to the account itself'], 401);
        }

        $accountData = $this->account->find($request->account);
        $accountToData = $this->account->find($request->account_to);

        if (!$accountData) return response()->json(['message' => 'account not found'], 404);
        if (!$accountToData) return response()->json(['message' => 'account_to not found'], 404);

        $user = $this->user->find($accountData->user_id);

        if (strlen($user->cpf_cnpj) === 14) return response()->json(['message' => 'this account cannot transfer'], 401);

        if ($accountData->balance < $request->value) return response()->json(['message' => 'insufficient funds'], 401);

        $account = $this->account->transfer($request->account, $request->account_to, $request->value);
        $this->transaction->create([
            'account_id' => $request->account,
            'account_to' => $request->account_to,
            'value' => $request->value
        ]);

        return response()->json($account);
    }

    function show(int $id)
    {
        $data = $this->account->find($id);
        return response()->json($data);
    }

    function showByUser(int $id)
    {
        $data = $this->account->whereByUser($id);
        if (!$data) return response()->json(['message' => 'user not found'], 404);

        return response()->json($data);
    }

    function delete($id)
    {
        $data = $this->account->find($id)?->delete();
        return response()->json($data);
    }
}
