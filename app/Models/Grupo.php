<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Turma;
use App\Models\Aluno;

class Grupo extends Model
{
    protected $table = 'grupos';

    protected $with = ['turma', 'alunos'];

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

    public function alunos(){
        return $this->hasMany(Aluno::class);
    }
}
