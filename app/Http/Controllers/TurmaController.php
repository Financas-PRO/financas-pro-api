<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTurmaRequest;
use App\Http\Requests\UpdateTurmaRequest;
use App\Models\Docente;
use App\Models\Turma;
use Exception;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {

            $obj = new Turma();
            $turma = $obj->all();

            return [
                "status" => true,
                'data' => $turma
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
    public function store(StoreTurmaRequest $request)
    {
        try {
            $turma = Turma::create($request->all());
            $turma->save();

            return [
                'status' => 1,
                'data' => $turma
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
    public function show(Turma $turma)
    {
        try {

            return [
                "status" => true,
                "data" => $turma
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
    public function update(UpdateTurmaRequest $request, Turma $turma)
    {
        try {
            $turma->update($request->all());

            return [
                "status" => true,
                "data" => $turma
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
    public function destroy(Turma $turma)
    {
        try {

            $turma->delete();

            return [
                "status" => true,
                "data" => $turma
            ];
        } catch (Exception $e) {

            return [
                "status" => false,
                "error" => $e->getMessage()
            ];
        }
    }
}
