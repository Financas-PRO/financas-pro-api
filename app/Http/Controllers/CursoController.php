<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
class CursoController extends Controller
{
    public function index()
    {

        $obj = new Curso();
        $curso = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $curso
        ];

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCursoRequest $request)
    {
        $curso = new Curso($request->only('curso'));
        $curso->save();

        return [
            'status' => true,
            'data' => $curso
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        return [
            'status' => true,
            'data' => $curso
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCursoRequest $request, Curso $curso)
    {
        $curso->update($request->only('curso'));

        return [
            "status" => true,
            "data" => $curso
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        $curso->ativo = 0;

        $curso->update();

        return [
            "status" => true,
            "data" => $curso
        ];
    }
}
