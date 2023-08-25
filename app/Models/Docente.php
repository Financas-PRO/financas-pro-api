<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Docente extends Model
{
    protected $with = ['user'];

    protected $fillable = [
        'nome',
        'titulacao',
        'rg',
        'cpf',
        'id_usuario',
        'telefone',
        'matricula'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id_usuario',
        'ativo'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }
}
