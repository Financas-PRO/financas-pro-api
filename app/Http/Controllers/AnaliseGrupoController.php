<?php

namespace App\Http\Controllers;

use App\Models\AnaliseGrupo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnaliseGrupoRequest;
use App\Http\Requests\UpdateAnaliseGrupoRequest;

class AnaliseGrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj = new AnaliseGrupo();
        $analiseGrupo = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $analiseGrupo
        ];
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnaliseGrupoRequest $request)
    {
        $analiseGrupo = AnaliseGrupo::create($request->all());
        $analiseGrupo->save();

        return [
            'status' => 1,
            'data' => $analiseGrupo
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(AnaliseGrupo $analiseGrupo)
    {
        return [
            "status" => true,
            "data" => $analiseGrupo
        ];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnaliseGrupoRequest $request, AnaliseGrupo $analiseGrupo)
    {
        $analiseGrupo->update($request->all());

        return [
            "status" => true,
            "data" => $analiseGrupo
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnaliseGrupo $analiseGrupo)
    {
        $analiseGrupo->ativo = 0;
        $analiseGrupo->update();

        return [
            "status" => true,
            "data" => $analiseGrupo
        ];
    }
}
