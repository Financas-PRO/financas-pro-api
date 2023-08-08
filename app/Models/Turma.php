<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
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
}
