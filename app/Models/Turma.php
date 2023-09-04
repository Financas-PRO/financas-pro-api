<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $fillable = [
        'ano',
        'semestre',
        'descricao',
        'id_docente'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id_disciplina'
    ];

}
