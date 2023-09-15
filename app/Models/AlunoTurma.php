<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Turma;
use App\Models\Aluno;

class AlunoTurma extends Model
{
    protected $with = ['aluno'];

    protected $fillable = [
        'id_turma',
        'id_aluno'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'ativo',
        'id_turma',
        'id_aluno'
    ];

    public function turma(){
        return $this->hasOne(Turma::class, 'id', 'id_turma');
    }

    public function aluno(){
        return $this->hasOne(Aluno::class, 'id', 'id_aluno');
    }
}