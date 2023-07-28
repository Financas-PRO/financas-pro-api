<?php

namespace App\Http\Controllers;

use App\Models\AlunoTurma;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlunoTurmaRequest;
use App\Http\Requests\UpdateAlunoTurmaRequest;

class AlunoTurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj = new AlunoTurma();
        $alunoTurma = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $alunoTurma
        ];
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlunoTurmaRequest $request)
    {
        $alunoTurma = AlunoTurma::create($request->all());
        $alunoTurma->save();

        return [
            'status' => 1,
            'data' => $alunoTurma
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(AlunoTurma $alunoTurma)
    {
        return [
            "status" => true,
            "data" => $alunoTurma
        ];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlunoTurmaRequest $request, AlunoTurma $alunoTurma)
    {
        $alunoTurma->update($request->all());

        return [
            "status" => true,
            "data" => $alunoTurma
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlunoTurma $alunoTurma)
    {
        $alunoTurma->ativo = 0;
        $alunoTurma->update();

        return [
            "status" => true,
            "data" => $alunoTurma
        ];
    }
}
