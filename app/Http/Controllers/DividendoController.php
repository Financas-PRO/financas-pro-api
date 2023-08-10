<?php

namespace App\Http\Controllers;

use App\Models\Dividendo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDividendoRequest;
use App\Http\Requests\UpdateDividendoRequest;

class DividendoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj = new Dividendo();
        $dividendo = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $dividendo
        ];
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDividendoRequest $request)
    {
        $dividendo = Dividendo::create($request->all());
        $dividendo->save();

        return [
            'status' => 1,
            'data' => $dividendo
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Dividendo $dividendo)
    {
        return [
            "status" => true,
            "data" => $dividendo
        ];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDividendoRequest $request, Dividendo $dividendo)
    {
        $dividendo->update($request->all());

        return [
            "status" => true,
            "data" => $dividendo
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dividendo $dividendo)
    {
        $dividendo->ativo = 0;
        $dividendo->update();

        return [
            "status" => true,
            "data" => $dividendo
        ];
    }
}
