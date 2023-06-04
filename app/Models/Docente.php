<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use User;

class Docente extends Model
{
    protected $fillable = [
        'nome',
        'titulacao',
        'rg',
        'cpf',
        'id_usuario',
        'telefone'
    ];
    public function usuario(){
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }
}
