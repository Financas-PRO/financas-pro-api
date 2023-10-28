<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Acao;

class AcaoHistorico extends Model
{
    protected $table = "acoeshistorico";

    protected $fillable = [
        'data_acao',
        'preco_abertura',
        'preco_mais_alto',
        'preco_mais_baixo',
        'preco_fechamento',
        'preco_fechamento_ajustado',
        'id_acao'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id_grupo',
        'ativo'
    ];

    public function acao(){
        return $this->belongsTo(Acao::class);
    }
        
}
