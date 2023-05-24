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
            $docentes = $obj->all();

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocenteRequest $request)
    {
        try {
            $usuario = User::create($request->only('username', 'password', 'email', 'id_tipoDeUsuario'));
            $usuario->save();


            $docente = new Docente($request->only('rg','cpf', 'titulacao', 'telefone','nome'));
            $docente->id_usuario = $usuario->id;
            $docente->save();

            $dados = [
                'usuario' => $usuario,
                'docente' => $docente,
            ];

            return [
                'status' => 1,
                'data' => $dados
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
    public function show(Docente $docentes)
    {
        try {

            return [
                "status" => true,
                "data" => $docentes
            ];
        } catch (Exception $e) {

            return [
                "status" => false,
                "error" => $e->getMessage(),
            ];
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocenteRequest $request, Docente $docentes)
    {
        try {
            $docentes->update($request->all());

            return [
                "status" => true,
                "data" => $docentes
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
    public function destroy(Docente $docentes)
    {
        try {

            $docentes->delete();

            return [
                "status" => true,
                "data" => $docentes
            ];
        } catch (Exception $e) {

            return [
                "status" => false,
                "error" => $e->getMessage()
            ];
        }
    }
}
