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
        if($user['password'] && Hash::info($user['password'])['algoName'] !== 'bcrypt') {
            $user['password'] = Hash::make($user['password']);
        }

        return $user;
    }

    public static function decrypt(User|array $user)
    {
        $email = OpensslUtils::decrypt($user['email']);
        $cpf = OpensslUtils::decrypt($user['cpf_cnpj']);

        $user['email'] = $email ? $email : $user['email'];
        $user['cpf_cnpj'] = $cpf ? $cpf : $user['cpf_cnpj'];

        return $user;
    }


    private static function cpfCnpjRules(array $rules = [], bool $unique = false) {
        $validCpfCnpj = function ($attribute, $value, $fail) use ($unique) {
            $regex = '/(^\d{3}\d{3}\d{3}\d{2}$)|(^\d{2}\d{3}\d{3}\d{4}\d{2}$)/';
            if(!preg_match($regex, $value)) {
                $fail($attribute.' is invalid.');
            }

            if(!$unique) return;

            $value = OpensslUtils::encrypt($value);
            $data = User::where([$attribute => $value])->get()->first();

            if($data) {
                $fail($attribute.' already registered.');
            }
        };

        array_push($rules, $validCpfCnpj);
        return $rules;
    }

    private static function emailRules(array $rules = [], bool $unique = false){
        $validEmailUnique = function ($attribute, $value, $fail) use ($unique) {

            if(!$unique) return;

            $value = OpensslUtils::encrypt($value);
            $data = User::where([$attribute => $value])->get()->first();
            if($data) {
                $fail($attribute.'already registered.');
            }
        };

        array_push($rules, $validEmailUnique);
        return $rules;
    }


    public static function storeRules()
    {
        return [
            'name' => 'required|string|min:10|max:150',
            'email' => self::emailRules(['required', 'email'], true),
            'cpf_cnpj' => self::cpfCnpjRules(['required'], true),
            'password' => 'required',
        ];
    }

    public static function updateRules()
    {
        return [
            'name' => 'string|min:10|max:150',
            'email' => self::emailRules(['email']),
            'cpf_cnpj' => self::cpfCnpjRules(),
        ];
    }



    public static function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'email.email' => 'Email is invalid!',

            'cpf_cnpj.required' =>  'CPF_CNPJ is required!',

            'name.string' => 'Name is not string!',
            'name.min' => 'Name contain less than ten digits!',
            'name.max' => 'Name contain more than fifty digits!'
        ];
    }
}
