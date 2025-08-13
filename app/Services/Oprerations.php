<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Oprerations
{
    public static function decryptId($value) {
        // chec if $value is encrypted
        try{
            $value = Crypt::decrypt($value);

        } catch (DecryptException $e){
            return redirect()->route('home');
        }
        return $value;
    }
}
