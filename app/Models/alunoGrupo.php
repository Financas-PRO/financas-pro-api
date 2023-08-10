<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grupo;
use App\Models\Aluno;

class alunoGrupo extends Model
{
    protected $with = ['aluno', 'grupo'];

    protected $fillable = [
        'id_grupo',
        'id_aluno'
    ];

    public function aluno(){
        return $this->hasOne(Aluno::class, 'id', 'id_aluno');
    }

    public function grupo(){
        return $this->hasOne(Grupo::class, 'id', 'id_grupo');
    }
}
