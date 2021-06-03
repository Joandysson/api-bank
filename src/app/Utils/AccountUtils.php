<?php

namespace App\Utils;

use App\Models\Account;
use App\Models\User;
use App\Utils\OpensslUtils;
use Illuminate\Support\Facades\Hash;

trait UserUtils
{
    private static function validUser(array $rules = []) {
        $validUser = function ($attribute, $value, $fail) {
            if(User::find($value)){
                $fail('');
            }

            Account::where([$attribute, $value])->get()->first();
        };

        array_push($rules, $validUser);
        return $rules;
    }

    private static function emailRules(array $rules = []){
        $validEmailUnique = function ($attribute, $value, $fail) {

        };

        array_push($rules, $validEmailUnique);
        return $rules;
    }


    public static function storeRules()
    {
        return [
            'user_id' => 'required|integer'
        ];
    }

    public static function depositRules()
    {
        return [
            'name' => 'string|min:10|max:150',
            'email' => self::emailRules(['email']),
            'cpf_cnpj' => self::cpfCnpjRules(),
        ];
    }

    public static function withdrawRules()
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
