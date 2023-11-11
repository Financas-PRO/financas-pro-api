<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Models\Grupo;
use App\Models\Docente;
use App\Models\Turma;

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
            'id_docente' => (Docente::where('id_usuario', auth()->id())->first())->id, 
            'id_grupo' => $grupo->id,
            'nota' => $dados['nota']
        ]);
        $feedback->save();
        $grupo->update(['etapa' => "Feedback concluído"]);
        
        return [
            'status' => true,
            'data' => $feedback
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Grupo $grupo)
    {
        $feedback = Feedback::where('id_grupo', $grupo->id)->get();

        return [
            "status" => true,
            "data" => isset($feedback[0]) ? $feedback[0] : null 
        ];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        $feedback->update($request->only('descricao'));

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

    public function relatorio(Turma $turma){
        
        $model = new Feedback();
        
        return [
            "status" => true,
            "data" => $model->getRelatorioNotas($turma->id)
        ];
    }
}
