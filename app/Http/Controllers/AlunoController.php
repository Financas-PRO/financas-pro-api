<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlunoRequest;
use App\Http\Requests\UpdateAlunoRequest;

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
}
