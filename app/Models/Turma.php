<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Docente;

class Turma extends Model
{
    protected $with = ['docente'];

    protected $fillable = [
        'ano',
        'semestre',
        'descricao',
        'id_docente'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id_docente'
    ];

    public function docente(){
        return $this->hasOne(Docente::class, 'id', 'id_docente');
    }

}
