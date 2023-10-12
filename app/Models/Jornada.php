<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grupo;

class Jornada extends Model
{
    protected $table = 'jornadas';
    
    protected $with = ['grupo'];

    protected $fillable = [
        'payload',
        'id_grupo',
        'etapa'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id_grupo',
        'ativo'
    ];

    public function grupo(){
        return $this->belongsTo(Grupo::class);
    }
}
