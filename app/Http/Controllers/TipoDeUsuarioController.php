<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTipoDeUsuarioRequest;
use App\Http\Requests\UpdateTipoDeUsuarioRequest;
use App\Models\tipoDeUsuario;

class TipoDeUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docentes = tipoDeUsuario::all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $docentes
        ];

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoDeUsuarioRequest $request)
    {

        $docente = new tipoDeUsuario($request->only('papel'));
        $docente->save();

        return [
            'status' => true,
            'data' => $docente
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(tipoDeUsuario $tipoDeUsuario)
    {

        return [
            "status" => true,
            "data" => $tipoDeUsuario
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoDeUsuarioRequest $request, tipoDeUsuario $tipoDeUsuario)
    {
        $tipoDeUsuario->update($request->only('papel'));

        return [
            "status" => true,
            "data" => $tipoDeUsuario
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tipoDeUsuario $tipoDeUsuario)
    {

        $tipoDeUsuario->ativo = 0;

        $tipoDeUsuario->update();

        return [
            "status" => true,
            "data" => $tipoDeUsuario
        ];
    }
}
