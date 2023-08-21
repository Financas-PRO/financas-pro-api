<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grupo;

class Jornada extends Model
{
    protected $table = 'jornadas';
    
    protected $with = ['grupo'];

    protected $fillable = [
        'nome',
        'id_grupo',
        'etapa'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'ativo'
    ];

    public function grupo(){
        return $this->hasOne(Grupo::class, 'id', 'id_grupo');
    }
}
