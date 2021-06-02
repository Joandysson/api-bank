<?php

namespace App\Utils;

use App\Models\User;
use App\Utils\OpensslUtils;
use Illuminate\Support\Facades\Hash;

trait UserUtils
{
    public static function encrypt(User|array $user)
    {
        if($user['email']) $user['email'] = OpensslUtils::encrypt($user['email']);
        if($user['cpf_cnpj']) $user['cpf_cnpj'] = OpensslUtils::encrypt($user['cpf_cnpj']);
        if($user['password']) $user['password'] = Hash::make($user['password']);

        return $user;
    }

    public static function decrypt(User|array $user)
    {
        $email = OpensslUtils::decrypt($user['email']);
        $cpf = OpensslUtils::decrypt($user['cpf']);

        $user['email'] = $email ? $email : $user['email'];
        $user['cpf'] = $cpf ? $cpf : $user['cpf'];

        return $user;
    }


    private static function cpfCnpjRules(array $rules = []) {
        $validCpfCnpj = function ($attribute, $value, $fail) {
            $regex = '/(^\d{3}\d{3}\d{3}\d{2}$)|(^\d{2}\d{3}\d{3}\d{4}\d{2}$)/';
            if(!preg_match($regex, $value)) {
                $fail($attribute.' is invalid.');
            }

            $value = OpensslUtils::encrypt($value);
            $data = User::where([$attribute => $value])->get()->first();

            if($data) {
                $fail($attribute.' already registered.');
            }
        };

        array_push($rules, $validCpfCnpj);
        return $rules;
    }

    private static function emailRules(array $rules = []){
        $validEmailUnique = function ($attribute, $value, $fail) {
            $value = OpensslUtils::encrypt($value);
            $data = User::where([$attribute => $value])->get()->first();

            if($data) {
                $fail($attribute.' already registered.');
            }
        };

        array_push($rules, $validEmailUnique);
        return $rules;
    }


    public static function storeRules()
    {
        return [
            'name' => 'required|string|min:10|max:100',
            'email' => self::emailRules(['required', 'email']),
            'cpf_cnpj' => self::cpfCnpjRules(['required']),
            'password' => 'required',
        ];
    }

    public static function updateRules()
    {
        return [
            'name' => 'string|min:10|max:100',
            'email' => 'email|unique:clients',
            'cpf' => 'digits:11'
        ];
    }



    public static function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'email.email' => 'Email is invalid!',

            'cpf.required' =>  'CPF is required!',
            'cpf.digits' =>  'CPF does not contain eleven digits!',

            'name.string' => 'Name is not string!',
            'name.min' => 'Name contain less than ten digits!',
            'name.max' => 'Name contain more than fifty digits!'
        ];
    }
}
