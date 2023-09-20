<?php

namespace App\Http\Controllers;

use App\Models\Acao;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAcaoRequest;
use App\Http\Requests\UpdateAcaoRequest;
use GuzzleHttp\Client;
use App\Http\Requests\ImportarAcaoRequest;

class AcaoController extends Controller
{
    

    public function capturarAcoesB3(ImportarAcaoRequest $request)
    {
        try {
            $client = new Client();

            $params = [
                'query' => [
                    'range' => $request->only('faixa')['faixa'],
                    'interval' => $request->only('intervalo')['intervalo'],
                    'fundamental' => true,
                    'dividends' => true
                ]
            ];

            $response = $client->get('https://brapi.dev/api/quote/' . implode(",", $request->only('empresas')['empresas']), $params);

            if ($response->getStatusCode() === 200) {
                $apiData = json_decode($response->getBody());

                // Itera sobre os dados da API para mapear e salvar no banco de dados
                foreach ($apiData as $apiAcao) {
                    $acao = new Acao();
                    $acao->simbolo = $apiAcao->symbol;
                    $acao->nome_curto = $apiAcao->shortName;
                    $acao->nome_completo = $apiAcao->longName;
                    $acao->preco_merc_regular = $apiAcao->regularMarketPrice;
                    $acao->alto_merc_regular = $apiAcao->regularMarketDayHigh;
                    $acao->baixo_merc_regular = $apiAcao->regularMarketDayLow;
                    $acao->intervalo_merc_regular = $apiAcao->regularMarketDayRange;
                    $acao->variacao_merc_regular = $apiAcao->regularMarketChange;
                    $acao->valor_merc = $apiAcao->marketCap;
                    $acao->volume_merc_regular = $apiAcao->regularMarketVolume;
                    $acao->fecha_ant_merc_regular = $apiAcao->regularMarketPreviousClose;
                    $acao->abertura_merc_regular = $apiAcao->regularMarketOpen;
                    $acao->link_logo = $apiAcao->logourl;
                    $acao->preco_lucro = $apiAcao->priceEarnings;
                    $acao->data_importacao = now(); //pegar data atual
                    $acao->id_grupo = $idDoGrupo; // Substitua pelo ID correto do grupo
                    $acao->ativo = true; 
                    
                    $acao->save();
                }

                
                return response()->json(['message' => 'Ações importadas com sucesso']);
            } else {             
                return response()->json(['error' => 'Erro na solicitação da API'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
