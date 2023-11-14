<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGrupoRequest;
use App\Http\Requests\UpdateGrupoRequest;
use App\Models\Aluno;
use App\Models\alunoGrupo;
use App\Models\Turma;
use App\Models\Acao;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Turma $turma)
    {
        if (auth()->user()->id_tipoDeUsuario == 3) {

            $grupos = alunoGrupo::whereRelation('grupo', 'id_turma', '=', $turma->id)
                ->where('ativo', 1)
                ->where('id_aluno', (Aluno::where('id_usuario', auth()->id())->first())->id)
                ->get()
                ->sortByDesc('created_at')
                ->pluck('grupo');
                
        } else {
            $retorno = Grupo::all()
                ->sortByDesc('created_at')
                ->where('ativo', 1)
                ->where('id_turma', $turma->id)
                ->values();

            $grupos = $retorno->filter(function ($grupo){
                return $grupo->etapa === "Aguardando feedback" || $grupo->etapa === "Feedback concluído";
            });
                
        }

        foreach ($grupos as $grupo){
            
            $grupo->alunos = alunoGrupo::with('aluno')
            ->where('ativo', 1)
            ->where('id_grupo', $grupo->id)
            ->get()
            ->pluck('aluno');

            $grupo->rota = Grupo::getRota($grupo);
        }

        return [
            "status" => true,
            'data' => $grupos
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGrupoRequest $request, Turma $turma)
    {
        $dados = $request->all();

        $grupo = new Grupo([
            "id_turma" => $turma->id, 
            "descricao" => $dados["descricao"],
            "etapa" => "Empresas"
        ]);

        $grupo->save();

        $alunos = $dados["alunos"];

        foreach ($alunos as $aluno){

            $aluno_grupo = new alunoGrupo([
                'id_grupo' => $grupo->id, 
                'id_aluno' => $aluno
            ]);
            
            $aluno_grupo->save();
        };
        
        return [
            'status' => true,
            'data' => $grupo
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Grupo $grupo)
    {
        return [
            "status" => true,
            "data" => $grupo
        ];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGrupoRequest $request, Grupo $grupo)
    {
        $dados = $request->all();
        $grupo->update(["etapa" => $dados['etapa']]);

        foreach ($dados["acoes"] as $dadoacao){

            $dadoacao = (object) $dadoacao;
            $acao = Acao::find($dadoacao->id);
            $acao->update(["planilha_grupo" => json_encode($dadoacao->planilha_grupo)]);
        }

        return [
            "status" => true,
            "data" => $grupo
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grupo $grupo)
    {
        $grupo->ativo = 0;
        $aluno_grupos= alunoGrupo::where('id_grupo', $grupo->id)->get();

        foreach ($aluno_grupos as $aluno_grupo){
            $aluno_grupo->ativo = 0;
            $aluno_grupo->update();
        };

        $grupo->update();

        return [
            "status" => true,
            "data" => $aluno_grupos
        ];
    }

    public function atualizarEtapa(UpdateGrupoRequest $request, Grupo $grupo){

        $grupo->update($request->only('etapa'));

        return [
            "status" => true,
            "data" => $grupo
        ];
    }
}
