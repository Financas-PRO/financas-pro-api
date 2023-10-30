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
        'etapa',
        'rota'
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

    public function getRota(){

        switch ($this->etapa){
            case "Empresas":
                $this->rota = "empresas/" . $this->id;
                break;

            case "Gráficos":
                $this->rota = "grafico/" . $this->id;
                break;

            case "Demonstrativo":
                $this->rota = "demonstrativo/" . $this->id;
                break;

            case "Análise":
                $this->rota = "analise/" . $this->id;
                break;

            case "Feedback":
                $this->rota = "aluno_feedback/" . $this->id;
                break;

            default:
                $this->rota = "cadastrar/" . $this->id;
        }
         
    }

}
