<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocenteRequest;
use App\Http\Requests\UpdateDocenteRequest;
use App\Models\Docente;
use App\Models\tipoDeUsuario;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {

            $obj = new Docente();
            $docentes = $obj->all()->where('ativo', 1);

            return [
                "status" => true,
                'data' => $docentes
            ];
        } catch (Exception $e) {

            return [
                "status" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocenteRequest $request)
    {
        try {
            $usuario = new User($request->only('username', 'password', 'email', 'id_tipoDeUsuario'));
            $usuario->save();
            $docente = new Docente($request->only('rg','cpf', 'titulacao', 'telefone','nome'));
            $docente->id_usuario = $usuario->id;
            $docente->save();

            return [
                'status' => 1,
                'data' => $docente
            ];

        } catch (Exception $e) {

            return [
                "status" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Docente $docente)
    {
        try {

            return [
                "status" => true,
                "data" => $docente
            ];

        } catch (Exception $e) {

            return [
                "status" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocenteRequest $request, Docente $docente)
    {
        try {

            $usuario = User::find($docente->user->id);

            $usuario->update($request->only('username', 'password', 'email', 'id_tipoDeUsuario'));
            $docente->update($request->only('rg','cpf', 'titulacao', 'telefone','nome'));

            return [
                "status" => true,
                "data" => $docente
            ];

        } catch (Exception $e) {

            return [
                "status" => false,
                "error" => $e->getMessage()
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {
        try {

            $usuario = User::find($docente->user->id);
            $usuario->ativo = 0;
            $docente->ativo = 0;
            $docente->update();
            $usuario->update();

            return [
                "status" => true,
                "data" => $docente
            ];
            
        } catch (Exception $e) {

            return [
                "status" => false,
                "error" => $e->getMessage()
            ];
        }
    }
}
