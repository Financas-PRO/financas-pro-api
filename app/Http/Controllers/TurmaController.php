<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTurmaRequest;
use App\Http\Requests\UpdateTurmaRequest;
use App\Models\Turma;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $obj = new Turma();
        $turma = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $turma
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTurmaRequest $request)
    {
        
        $turma = new Turma([
            'descricao' => $request->descricao,
            'semestre' => $request->semestre,
            'ano' => $request->ano,
            'id_usuario' => auth()->user()->id
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
        $turma->update([
            'descricao' => $request->descricao,
            'semestre' => $request->semestre,
            'ano' => $request->ano,
            'id_usuario' => auth()->user()->id
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

        $turma->ativo = 0;
        $turma->update();

        return [
            "status" => true,
            "data" => $turma
        ];
    }
}
