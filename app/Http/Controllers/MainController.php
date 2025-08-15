<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
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
       // show new note view
       return view('new_note');
   }

   public function newNoteSubmit(Request $request)
   {
       // validate request
       $request->validate([
           // rules
           'text_title'=>'required|min:3|max:200',
           'text_note'=>'required|min:3|max:3000'
       ],
           [
               // error messages
               'text_title.required'=>'O titulo é obrigatorio',
               'text_title.max'=>'O titulo deve ter no máximo :max caracteres',
               'text_title.min'=>'O titulo deve ter pelo menos :min caracteres',
               'text_note.required'=>'A nota deve ser obrigatoria',
               'text_note.min'=>'A nota deve ter pelo menos :min caracteres',
               'text_note.max'=>'A nota deve ter no máximo :max caracteres',
           ]
       );

       // get user id
       $id = session('user.id');

       // create new note
       $note = new Note();
       $note->user_id = $id;
       $note->title = $request->text_title;
       $note->text = $request->text_note;
       $note->save();

       // redirect to home
       return redirect()->route('home');
   }

   public function editNote($id)
   {
       $id = Operations::decryptId($id);

       // load note
       $note = Note::find($id);

       // show edit note view
       return view('edit_note', ['note' => $note]);
   }

   public function editNoteSubmit(Request $request){
       // validate request
       $request->validate([
           // rules
           'text_title'=>'required|min:3|max:200',
           'text_note'=>'required|min:3|max:3000'
       ],
           [
               // error messages
               'text_title.required'=>'O titulo é obrigatorio',
               'text_title.max'=>'O titulo deve ter no máximo :max caracteres',
               'text_title.min'=>'O titulo deve ter pelo menos :min caracteres',
               'text_note.required'=>'A nota deve ser obrigatoria',
               'text_note.min'=>'A nota deve ter pelo menos :min caracteres',
               'text_note.max'=>'A nota deve ter no máximo :max caracteres',
           ]
       );

       // check if note_id exists
       if($request->note_id == null){
           return redirect()->route('home');
       }
       // dercrypt note_id
       // esse é operation é uma classe que está em services,
       // serve para descriptografar o id do usuario que fez
       // uma nota e para para a variavel $id
       $id = Operations::decryptId($request->note_id);

       // load note
       // acesso o $id no banco com a função find do orm
       // e passo para a note
       $note = Note::find($id);

       // update note
       // e aqui eu acesso as informações do $request
       // e passo para os objetos e salvo no banco de dados
       $note->title = $request->text_title;
       $note->text = $request->text_note;
       $note->save();

       // redirect to home
      return redirect()->route('home');

   }

    public function DeleteNote($id)
    {
        $id = Operations::decryptId($id);
        echo "I'm deleting note witch id = $id";
    }

}
