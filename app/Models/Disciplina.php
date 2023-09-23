<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{

    protected $fillable = [
        'nome'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'ativo'
    ];
}
