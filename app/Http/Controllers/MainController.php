<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
   public  function index(){
      // load user's notes
      $id = session('user.id');
      $notes = User::find($id)->notes()->get()->toArray();


       // show home view
       return view('home', ['notes' => $notes]);
   }

   public function newNote()
   {
       echo "I'm inside the app!";
   }

   public function editNote($id)
   {
       $id = $this->decryptId($id);
       echo "I'm editing note witch id = $id";
   }

    public function DeleteNote($id)
    {
       $id = $this->decryptId($id);
        echo "I'm deleting note witch id = $id";
    }

    private function decryptId($id){
       // chec if $id is encrypted
        try{
            $id = Crypt::decrypt($id);

        } catch (DecryptException $e){
            return redirect()->route('home');
        }
        return $id;

    }

}
