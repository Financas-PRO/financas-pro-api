<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDisciplinaRequest;
use App\Http\Requests\UpdateDisciplinaRequest;
use App\Models\Disciplina;

class DisciplinaController extends Controller
{
    public function index()
    {

        $obj = new Disciplina();
        $disciplina = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $disciplina
        ];

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDisciplinaRequest $request)
    {
        $disciplina = new Disciplina($request->only('curso'));
        $disciplina->save();

        return [
            'status' => true,
            'data' => $disciplina
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Disciplina $disciplina)
    {
        return [
            'status' => true,
            'data' => $disciplina
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDisciplinaRequest $request, Disciplina $disciplina)
    {
        $disciplina->update($request->only('nome'));

        return [
            "status" => true,
            "data" => $disciplina
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disciplina $disciplina)
    {
        $disciplina->ativo = 0;

        $disciplina->update();

        return [
            "status" => true,
            "data" => $disciplina
        ];
    }
}
