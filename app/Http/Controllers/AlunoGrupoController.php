<?php

namespace App\Http\Controllers;

use App\Models\alunoGrupo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorealunoGrupoRequest;
use App\Http\Requests\UpdatealunoGrupoRequest;

class alunoGrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $obj = new alunoGrupo();
        $alunoGrupo = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $alunoGrupo
        ];
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorealunoGrupoRequest $request)
    {
        $alunoGrupo = alunoGrupo::create($request->all());
        $alunoGrupo->save();

        return [
            'status' => 1,
            'data' => $alunoGrupo
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(alunoGrupo $alunoGrupo)
    {
        return [
            "status" => true,
            "data" => $alunoGrupo
        ];
    }

  

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatealunoGrupoRequest $request, alunoGrupo $alunoGrupo)
    {
        $alunoGrupo->update($request->all());

        return [
            "status" => true,
            "data" => $alunoGrupo
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(alunoGrupo $alunoGrupo)
    {
        $alunoGrupo->ativo = 0;
        $alunoGrupo->update();

        return [
            "status" => true,
            "data" => $alunoGrupo
        ];
    }
}
