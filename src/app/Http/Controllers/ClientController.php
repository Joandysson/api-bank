<?php

namespace App\Http\Controllers;

use App\Models\Client;


class ClientController extends Controller
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
