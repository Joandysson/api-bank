<?php

namespace App\Utils;

trait OpensslUtils
{

    public static function encrypt(string $text)
    {
        return openssl_encrypt($text, env('CIPHER'), env('APP_KEY'), OPENSSL_CMS_NOATTR, env('IV'));
    }

    public static function decrypt(string $text)
    {
        return openssl_decrypt($text, env('CIPHER'), env('APP_KEY'), OPENSSL_CMS_NOATTR, env('IV'));
    }
}