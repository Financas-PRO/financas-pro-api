<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Turma;

class Grupo extends Model
{
    protected $table = 'grupos';

    protected $with = ['turma', 'jornada'];

    protected $fillable = [
        'descricao',
        'id_turma'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id_turma',
        'ativo'
    ];

    public function turma(){
        return $this->hasOne(Turma::class, 'id', 'id_turma');
    }

    public function jornada(){
        return $this->hasOne(Jornada::class, 'id');
    }
}
