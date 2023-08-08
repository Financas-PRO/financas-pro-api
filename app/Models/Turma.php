<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Curso;

class Turma extends Model
{
    protected $with = ['curso'];

    protected $fillable = [
        'ano',
        'semestre',
        'id_curso',
        'turma'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function curso(){
        return $this->hasOne(Curso::class, 'id', "id_curso");
    }
}
