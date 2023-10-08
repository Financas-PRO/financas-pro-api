<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grupo;
use App\Models\Dividendo;

class Acao extends Model
{
    protected $with = ['grupo', 'dividendos'];

    protected $table = 'acoes';

    protected $fillable = [
        'simbolo',
        'nome_curto',
        'nome_completo',
        'preco_merc_regular',
        'alto_merc_regular',
        'baixo_merc_regular',
        'intervalo_merc_regular',
        'variacao_merc_regular',
        'valor_merc',
        'volume_merc_regular',
        'fecha_ant_merc_regular',
        'abertura_merc_regular',
        'link_logo',
        'preco_lucro',
        'data_importacao',
        'id_grupo'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id_grupo',
        'ativo'
    ];

    public function grupo(){
        return $this->hasOne(Grupo::class, 'id', 'id_grupo');
    }

    public function dividendos(){
        return $this->hasMany(Dividendo::class, 'id_acao', 'id');
    }
}
