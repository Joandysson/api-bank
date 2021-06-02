<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Utils\ClientUtils;
use Laravel\Lumen\Http\Request;

class UserController extends Controller
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

        $request->validate(ClientUtils::storeRules(), ClientUtils::messages());

        try {
            $data = $request->toArray();
            $this->client::create($request->all());
        } catch (\Throwable $th) {
            //throw $th;
        }

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
