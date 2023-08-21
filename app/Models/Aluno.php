<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Curso;

class Aluno extends Model
{
    protected $with = ['user', 'curso'];

    protected $fillable = [
        'nome',
        'ra',
        'id_usuario',
        'id_curso',
        'termo'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }

    public function curso(){
        return $this->hasOne(Curso::class, 'id', 'id_curso');
    }
}
