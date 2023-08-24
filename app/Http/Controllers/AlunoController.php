<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlunoRequest;
use App\Http\Requests\UpdateAlunoRequest;
use Illuminate\Http\Request;

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

    public function importarAlunos(Request $request)
    {
        $alunos = Aluno::importarAlunos($request->file('txt')->get());

        $importados = [];

        foreach ($alunos as $aluno) {

            // $disciplina = Disciplina::where('nome', $aluno->disciplina);
            $curso = DB::table('cursos')->where('curso', $aluno->curso)->first();

            $model_usuario = new User(['username' => $aluno->username, 'password' => "teste", "email" => $aluno->email, 'id_tipoDeUsuario' => 3]);
            $model_usuario->save();
            $model_aluno = new Aluno(['nome' => $aluno->nome, 'ra' => $aluno->ra, 'id_usuario' => $model_usuario->id, "id_curso" => $curso->id, 'termo' => $aluno->termo]);
            $model_aluno->save();


            array_push($importados, $model_aluno);

        };

        return [
            'status' => true,
            'alunos_importados' => $importados
        ];
    }
}
