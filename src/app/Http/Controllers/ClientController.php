<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Laravel\Lumen\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;

class ClientController extends Controller
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    function index(Request $request)
    {
    }

    function create(Request $request)
    {
        try {
            $data = $request->all();
            $this->client::create($request->all());
        } catch (\Throwable $th) {
            //throw $th;
        }

        Hash::make();
        Hash::check('', '');

    }

    function update(Request $request)
    {

    }

    function show(Request $request)
    {

    }

    function delete(Request $request)
    {

    }
}
