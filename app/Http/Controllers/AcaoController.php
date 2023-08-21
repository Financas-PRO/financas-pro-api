<?php

namespace App\Http\Controllers;

use App\Models\Acao;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAcaoRequest;
use App\Http\Requests\UpdateAcaoRequest;
use GuzzleHttp\Client;

class AcaoController extends Controller
{
    public function capturarAcoesB3(){

        $client = new Client();

        try{
            $response  = $client->get('https://api.b3.com.br/v2/stocks/quotes?symbols=PETR4,VALE3');
            // Processar e retornar os dados conforme necessário
            $quotes = json_decode($response->getBody(), true);
            var_dump($quotes);
        }
            catch(\Exception $e){
                return response()->json(['error' =>'Erro ao acessar a API da B3, por favor, tente novamente', 500]);
            }

        }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj = new Acao();
        $acoes = $obj->all()->where('ativo', 1)->values();

        return [
            "status" => true,
            'data' => $acoes
        ];

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcaoRequest $request)
    {
        $acoes = Acao::create($request->all());
        $acoes->save();

        return [
            'status' => 1,
            'data' => $acoes
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Acao $acao)
    {
        return [
            "status" => true,
            "data" => $acao
        ];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcaoRequest $request, Acao $acao)
    {
        $acao->update($request->all());

        return [
            "status" => true,
            "data" => $acao
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Acao $acao)
    {
        $acao->ativo = 0;
        $acao->update();

        return [
            "status" => true,
            "data" => $acao
        ];
    }
}
