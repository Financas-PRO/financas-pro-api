<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Acao;

class Dividendo extends Model
{
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
        'ativo',
        'id_acao'
    ];

    public function acao(){
        return $this->belongsTo(Acao::class);
    }
    
}
