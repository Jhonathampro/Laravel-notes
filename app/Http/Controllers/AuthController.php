<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    // eu tenho um botão em login para carregar essa condição
    public function loginSubmit(Request $request){
        // form validation
        $request->validate([
            'text_username'=>'required|email',
            'text_password'=>'required|min:6|max:16'
        ],
        [
            'text_username.required'=>'O username é obrigatorio',
            'text_username.email'=>'O username deve ser um email valido',
            'text_password.required'=>'A passoword deve ser obrigatoria',
            'text_password.min'=>'A passoword deve ter pelo menos 6 caracteres',
            'text_password.max'=>'A passoword deve ter no máximo 16 caracteres',
        ]
        );

        $username = $request->input('text_username');
        $password = $request->input('text_password');

        try{
          DB::connection()->getPdo();
          echo "OK" . $username;
        }  catch(\PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }


    }

    public function logout(){
        echo 'logout';
    }
}
