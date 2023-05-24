<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoDeUsuario extends Model
{
    use HasFactory;

    public function usuarios (){
        return $this->hasMany(tipoDeUsuario::class, 'id', 'id_tipoDeUsuario');
    }

}
