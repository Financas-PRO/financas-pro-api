<?php

namespace App\Http\Controllers;

use App\Models\AnaliseGrupo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnaliseGrupoRequest;
use App\Http\Requests\UpdateAnaliseGrupoRequest;
use App\Models\Grupo;
use App\Models\Aluno;
use App\Models\alunoGrupo;
use Exception;
use Illuminate\Validation\ValidationException;

class AnaliseGrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj = new AnaliseGrupo();
        $analiseGrupo = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $analiseGrupo
        ];
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnaliseGrupoRequest $request, Grupo $grupo)
    {
        $alunos_grupo = alunoGrupo::where('id_grupo', $grupo->id)
        ->get()
        ->pluck('aluno')
        ->pluck('id');

        $busca_analise = AnaliseGrupo::getAnaliseAluno($alunos_grupo, $grupo->turma->id);

        if ($busca_analise < 1) {

            $dados = $request->all();

            $analiseGrupo = new AnaliseGrupo([
                'descricao' => $dados['descricao'],
                'id_grupo' => $grupo->id
            ]);
            
            $analiseGrupo->save();
            $grupo->update(['etapa' => "Aguardando feedback"]);

            return [
                'status' => 1,
                'data' => $analiseGrupo
            ];

        } else throw new Exception("O grupo apresenta usuários que já enviaram feedback anteriormente.");

    }

    /**
     * Display the specified resource.
     */
    public function show(Grupo $grupo)
    {

        $analiseGrupo = AnaliseGrupo::where('id_grupo', $grupo->id)->get();

        return [
            "status" => true,
            "data" => isset($analiseGrupo[0]) ? $analiseGrupo[0] : null
        ];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnaliseGrupoRequest $request, AnaliseGrupo $analiseGrupo)
    {
        $analiseGrupo->update($request->only('descricao'));

        return [
            "status" => true,
            "data" => $analiseGrupo
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnaliseGrupo $analiseGrupo)
    {
        $analiseGrupo->ativo = 0;
        $analiseGrupo->update();

        return [
            "status" => true,
            "data" => $analiseGrupo
        ];
    }
}
