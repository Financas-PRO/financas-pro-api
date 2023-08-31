<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocenteRequest;
use App\Http\Requests\UpdateDocenteRequest;
use App\Models\Docente;
use App\Models\User;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docentes = Docente::all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $docentes
        ];

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocenteRequest $request)
    {
        $usuario = new User($request->only('username', 'password', 'email', 'id_tipoDeUsuario'));
        $usuario->save();
        $docente = new Docente($request->only('rg', 'cpf', 'titulacao', 'telefone', 'nome', 'matricula'));
        $docente->id_usuario = $usuario->id;
        $docente->save();

        return [
            'status' => true,
            'data' => $docente
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Docente $docente)
    {
        return [
            "status" => true,
            "data" => $docente
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocenteRequest $request, Docente $docente)
    {

        $usuario = User::find($docente->user->id);

        $usuario->update($request->only('username', 'password', 'email', 'id_tipoDeUsuario'));
        $docente->update($request->only('rg', 'cpf', 'titulacao', 'telefone', 'nome', 'titulacao'));

        return [
            "status" => true,
            "data" => $docente
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {

        $usuario = User::find($docente->user->id);
        $usuario->ativo = 0;
        $docente->ativo = 0;
        $docente->update();
        $usuario->update();

        return [
            "status" => true,
            "data" => $docente
        ];
    }
}
