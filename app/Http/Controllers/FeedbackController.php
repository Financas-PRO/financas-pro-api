<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Models\Grupo;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj = new Feedback();
        $feedback = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $feedback
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeedbackRequest $request, Grupo $grupo)
    {
        $dados = $request->all();
        $feedback = new Feedback([
            'descricao' => $dados['descricao'],
            'id_usuario' => auth()->user()->id,
            'id_grupo' => $grupo->id
        ]);
        $feedback->save();

        return [
            'status' => 1,
            'data' => $feedback
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        return [
            "status" => true,
            "data" => $feedback
        ];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        $dados = $request->all();

        $feedback->update([
            'descricao' => $dados['descricao'],
            'id_usuario' => auth()->user()->id
        ]);

        return [
            "status" => true,
            "data" => $feedback
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->ativo = 0;
        $feedback->update();

        return [
            "status" => true,
            "data" => $feedback
        ];
    }
}
