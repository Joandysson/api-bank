<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use App\Utils\UserUtils;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    function index(Request $request)
    {
        $data = $this->user->all();

        return response()->json($data);
    }

    function store(Request $request)
    {
        $this->validate($request, UserUtils::storeRules(), UserUtils::messages());

        try {
            $data = $this->user->create($request->all());

        } catch (\Exception $e) {
            dd($e->getMessage());
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
