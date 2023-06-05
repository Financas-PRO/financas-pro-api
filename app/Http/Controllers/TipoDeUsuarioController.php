<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTipoDeUsuarioRequest;
use App\Http\Requests\UpdateTipoDeUsuarioRequest;
use App\Models\tipoDeUsuario;
use Illuminate\Http\Request;
use Exception;

class TipoDeUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {

            $obj = new tipoDeUsuario();
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
    public function store(StoreTipoDeUsuarioRequest $request)
    {
        try {

            $docente = new tipoDeUsuario($request->all());
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
    public function show(tipoDeUsuario $tipoDeUsuario)
    {
        try {

            return [
                "status" => true,
                "data" => $tipoDeUsuario
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
    public function update(UpdateTipoDeUsuarioRequest $request, tipoDeUsuario $tipoDeUsuario)
    {
        try {
            $tipoDeUsuario->update($request->all());

            return [
                "status" => true,
                "data" => $tipoDeUsuario
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
    public function destroy(tipoDeUsuario $tipoDeUsuario)
    {
        try {

            $tipoDeUsuario->ativo = 0;

            $tipoDeUsuario->update();

            return [
                "status" => true,
                "data" => $tipoDeUsuario
            ];
            
        } catch (Exception $e) {

            return [
                "status" => false,
                "error" => $e->getMessage()
            ];
        }
    }
}
