<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Turma;

class Grupo extends Model
{
    protected $table = 'grupos';

    protected $with = ['turma'];

    protected $fillable = [
        'descricao',
        'id_turma'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'ativo'
    ];

    public function turma(){
        $this->hasOne(Turma::class, 'id', 'id_turma');
    }
}
