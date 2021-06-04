<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\TransactionRepository;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(
        protected TransactionRepository $transaction,
    ) {
        //
    }

    function index()
    {
        return response()->json($this->transaction->all());
    }
}
