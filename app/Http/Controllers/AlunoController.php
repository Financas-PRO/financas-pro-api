<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use App\Models\AlunoTurma;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlunoRequest;
use App\Http\Requests\UpdateAlunoRequest;
use App\Http\Requests\ImportarAlunoRequest;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj = new Aluno();
        $aluno = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $aluno
        ];
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlunoRequest $request)
    {
        $aluno = Aluno::create($request->all());
        $aluno->save();

        return [
            'status' => 1,
            'data' => $aluno
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Aluno $aluno)
    {
        return [
            "status" => true,
            "data" => $aluno
        ];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlunoRequest $request, Aluno $aluno)
    {
        $aluno->update($request->all());

        return [
            "status" => true,
            "data" => $aluno
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aluno $aluno)
    {
        $aluno->ativo = 0;
        $aluno->update();

        return [
            "status" => true,
            "data" => $aluno
        ];
    }

    public function importarAlunos(ImportarAlunoRequest $request, Turma $turma)
    {
        $model = new Aluno();

        $array_alunos = $model->tratarArquivoAlunos($request->file('txt')->get());

        $alunos = $model->importarAlunos($array_alunos);

        foreach ($alunos as $aluno){

            $aluno_turma = new AlunoTurma(["id_turma" => $turma->id, "id_aluno" => $aluno->id]);
            $aluno_turma->save();
            $model->enviarEmail();
        }
        
        return [
            'status' => true,
            'alunos_importados' => $alunos
        ];
    }

    public function retornaRelacaoTurma(Turma $turma){

        $alunos = AlunoTurma::where("id_turma", $turma->id)->get();
        return [
            'status' => true,
            'data' => $alunos
        ];
    }

}
