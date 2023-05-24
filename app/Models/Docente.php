<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use User;

class Docente extends Model
{
    use HasFactory;


    public function usuario(){
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }
}
