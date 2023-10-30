<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGrupoRequest;
use App\Http\Requests\UpdateGrupoRequest;
use App\Models\Aluno;
use App\Models\alunoGrupo;
use App\Models\Turma;

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
                ->pluck('grupo');
                
        } else {
            $grupos = Grupo::all()
                ->where('ativo', 1)
                ->where('id_turma', $turma->id)
                ->values();
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
        $grupo->update($request->all());

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
