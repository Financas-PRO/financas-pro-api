<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grupo;
use App\Models\Docente;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $with = ['grupo', 'docente'];

    protected $fillable = [
        'descricao',
        'id_docente',
        'id_grupo'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'ativo',
        'id_docente',
        'id_grupo'
    ];

    public function grupo(){
        return $this->hasOne(Grupo::class, 'id', 'id_grupo');
    }

    public function docente(){
        return $this->hasOne(Docente::class, 'id', 'id_docente');
    }
}
