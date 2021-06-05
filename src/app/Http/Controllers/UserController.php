<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use App\Utils\UserUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    function index()
    {
        return response()->json($this->user->all());
    }

    function store(Request $request)
    {
        $this->validate($request, UserUtils::storeRules(), UserUtils::messages());

        try {
            $data = $this->user->save($request->all());
            return response()->json($data, 201);
        } catch (\Exception $e) {
            return response()->json(['messege' => $e->getMessage()], 500);
        }
    }

    function update(Request $request, $id)
    {
        $this->validate($request, UserUtils::updateRules(), UserUtils::messages());

        $data = $this->user->find($id);

        if(!$data)  return response()->json(['messege' => 'User not found'], 404);

        $requestData = $request->all();

        if(isset($requestData['password_current']) && isset($data['password'])){
            $checked = Hash::check($requestData['password_current'], $data['password']);
            if(!$checked) return response()->json(['messege' => 'password_current invalid'], 401);
        }

        $updated = $this->user->createOrUpdate([
            'name' => $requestData['name'] ?? null,
            'email' => $requestData['email'] ?? null,
            'cpf_cnpj' => $requestData['cpf_cnpj'] ?? null,
            'password' => $requestData['password_new'] ?? null
        ], $data->id);

        return response()->json($updated);
    }

    function show(int $id)
    {
        $data = $this->user->find($id);
        return response()->json($data);
    }

    function delete($id)
    {
        $data = $this->user->find($id)?->delete();
        return response()->json($data);
    }
}
