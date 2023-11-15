<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTurmaRequest;
use App\Http\Requests\UpdateTurmaRequest;
use App\Models\AlunoTurma;
use App\Models\Turma;
use App\Models\Docente;
use App\Models\Aluno;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->id_tipoDeUsuario == 3) {

            $turmas = AlunoTurma::with('turma')
                ->where('ativo', 1)
                ->where('id_aluno', (Aluno::where('id_usuario', auth()->id())->first())->id)
                ->get()
                ->sortByDesc('created_at')                
                ->pluck('turma')
                ->values();
        } else {
            $turmas = Turma::all()
                ->sortByDesc('created_at')
                ->where('id_docente', (Docente::where('id_usuario', auth()->id())->first())->id)
                ->values();
        }

        return [
            "status" => true,
            'data' => $turmas
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTurmaRequest $request)
    {
        $dados = $request->all();
        $turma = new Turma([
            'descricao' => $dados['descricao'],
            'semestre' => $dados['semestre'],
            'ano' => $dados['ano'],
            'id_docente' => (Docente::where('id_usuario', auth()->id())->first())->id
        ]);
        $turma->save();

        return [
            'status' => true,
            'data' => $turma
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Turma $turma)
    {

        return [
            "status" => true,
            "data" => $turma
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTurmaRequest $request, Turma $turma)
    {
        $dados = $request->all();

        $turma->update([
            'descricao' => $dados['descricao'],
            'semestre' => $dados['semestre'],
            'ano' => $dados['ano'],
            'id_docente' => (Docente::where('id_usuario', auth()->id())->first())->id
        ]);

        return [
            "status" => true,
            "data" => $turma
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turma $turma)
    {

        $turma->ativo ?  $turma->ativo = 0 : $turma->ativo = 1;
        $turma->update();

        return [
            "status" => true,
            "data" => $turma
        ];
    }
}
