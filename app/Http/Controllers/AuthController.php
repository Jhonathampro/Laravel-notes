<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        // check if user exists
        $user = User::where('username', $username)
                        ->where('deleted_at', null)
                        ->first();

        if(!$user){
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username ou password invalido');
        }

        // check if password is correct
        if(!password_verify($password, $user->password)){
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username ou password invalido');
        }

        // update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login user
        session(['user'=>[
            'id'=>$user->id,
            'username'=>$user->username,
        ]]);

        echo 'Login com sucesso';



    }

    public function logout(){
        echo 'logout';
    }
}
