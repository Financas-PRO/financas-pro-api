<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Turma;

class Grupo extends Model
{
    protected $table = 'grupos';

    protected $with = ['turma'];

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

    public static function getRota($grupo){

        switch ($grupo->etapa){
            case "Empresas":
                return "empresas/" . $grupo->id;
                break;

            case "Gráficos":
                return "grafico/" . $grupo->id;
                break;

            case "Demonstrativo":
                return "demonstrativo/" . $grupo->id;
                break;

            case "Análise":
                return "analise/" . $grupo->id;
                break;

            case "Feedback":
                return "aluno_feedback/" . $grupo->id;
                break;

            default:
                return "cadastrar/" . $grupo->id;
        }
         
    }

}
