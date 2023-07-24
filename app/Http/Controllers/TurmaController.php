<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTurmaRequest;
use App\Http\Requests\UpdateTurmaRequest;
use App\Models\Docente;
use App\Models\Turma;
use Exception;
use Illuminate\Http\Request;

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

        $turma = Turma::create($request->all());
        $turma->save();

        return [
            'status' => 1,
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
        $turma->update($request->all());

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
