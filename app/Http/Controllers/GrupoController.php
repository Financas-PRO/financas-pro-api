<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGrupoRequest;
use App\Http\Requests\UpdateGrupoRequest;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj = new Grupo();
        $grupo = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $grupo
        ];
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGrupoRequest $request)
    {
        $grupo = Grupo::create($request->all());
        $grupo->save();
        
        return [
            'status' => 1,
            'data' => $grupo
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Grupo $grupo)
    {
        return [
            "status" => true,
            "data" => $grupo
        ];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGrupoRequest $request, Grupo $grupo)
    {
        $grupo->update($request->all());

        return [
            "status" => true,
            "data" => $grupo
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grupo $grupo)
    {
        $grupo->ativo = 0;
        $grupo->update();

        return [
            "status" => true,
            "data" => $grupo
        ];
    }
}
