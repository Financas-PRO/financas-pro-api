<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Turma;
use App\Models\alunoGrupo;

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
        // 'updated_at',
        'id_turma',
        'ativo'
    ];

    public function turma(){
        return $this->hasOne(Turma::class, 'id', 'id_turma');
    }

    public static function getRota($grupo){

        switch ($grupo->etapa){
            case "Empresas":
                return "/empresa/" . $grupo->id;
                break;

            case "Aguardando feedback":
                return "/feedback/" . $grupo->id;
                break;

            case "Demonstrativo":
                return "/demonstrativo/" . $grupo->id;
                break;

            case "Análise":
                return "/analise/" . $grupo->id;
                break;

            case "Feedback concluído":
                return "/feedback/" . $grupo->id;
                break;

            default:
                return "/";
        }
         
    }

    public function retornarUltimosGrupos(int $id_aluno){
        $grupos = alunoGrupo::all()
        ->sortByDesc('updated_at')
        ->where('ativo', 1)
        ->where('id_aluno', $id_aluno)
        ->pluck('grupo')
        ->take(3);

        foreach ($grupos as $grupo){
            
            $grupo->alunos = alunoGrupo::with('aluno')
            ->where('ativo', 1)
            ->where('id_grupo', $grupo->id)
            ->get()
            ->pluck('aluno');

            $grupo->rota = Grupo::getRota($grupo);
        }

        return $grupos;
    }

}
