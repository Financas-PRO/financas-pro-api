<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnaliseGrupo extends Model
{

    protected $fillable = [
        'id_grupo',
        'descricao'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'ativo'
    ];
}
