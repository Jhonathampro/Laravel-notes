<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function notes(){
        return $this->HasMany(Note::class);
    }
}
