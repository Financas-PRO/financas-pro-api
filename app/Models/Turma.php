<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{

    protected $fillable = [
        'ano',
        'semestre',
        'id_disciplina',
        'turma'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id_disciplina'
    ];

    // public function curso(){
    //     return $this->hasOne(Curso::class, 'id', "id_curso");
    // }
}
