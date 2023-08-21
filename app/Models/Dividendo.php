<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Acao;

class Dividendo extends Model
{
    protected $with = ['acao'];

    protected $fillable = [
        'ativo_emitido',
        'taxa',
        'relacionado',
        'rotulo',
        'codigoISIN',
        'id_acao'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function acao(){
        return $this->hasOne(Acao::class, 'id', 'id_acao');
    }
}
