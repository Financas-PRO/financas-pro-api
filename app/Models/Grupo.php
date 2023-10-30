<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Turma;

class Grupo extends Model
{
    protected $table = 'grupos';

    protected $with = ['turma', 'rota_etapa'];

    protected $fillable = [
        'descricao',
        'id_turma',
        'etapa'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id_turma',
        'ativo'
    ];

    public function turma(){
        return $this->hasOne(Turma::class, 'id', 'id_turma');
    }

    public function rota_etapa(){

        switch ($this->etapa){
            case "Empresas":
                return "empresas/" . $this->id;
                break;

            case "Gráficos":
                return "grafico/" . $this->id;
                break;

            case "Demonstrativo":
                return "demonstrativo/" . $this->id;
                break;

            case "Análise":
                return "analise/" . $this->id;
                break;

            case "Feedback":
                return "aluno_feedback/" . $this->id;
                break;

            default:
                return "cadastrar/" . $this->id;
        }
         
    }

}
