<?php

namespace App\Http\Controllers;

use App\Models\Jornada;
use App\Models\Grupo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJornadaRequest;
use App\Http\Requests\UpdateJornadaRequest;

class JornadaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj = new Jornada();
        $jornada = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $jornada
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJornadaRequest $request, Grupo $grupo)
    {
        $dados = $request->all();

        $jornada = new Jornada([
            'payload' => $dados['payload'], 
            'etapa' => $dados['etapa'],
            'id_grupo' => $grupo->id
        ]);

        $jornada->save();
        
        return [
            'status' => true,
            'data' => $jornada
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Jornada $jornada)
    {
        return [
            "status" => true,
            "data" => $jornada
        ];
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJornadaRequest $request, Jornada $jornada)
    {
        $jornada->update($request->only('payload', 'etapa'));

        return [
            "status" => true,
            "data" => $jornada
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jornada $jornada)
    {
        $jornada->ativo = 0;
        $jornada->update();

        return [
            "status" => true,
            "data" => $jornada
        ];
    }
}
