<?php

namespace App\Http\Controllers;

use App\Models\Acao;
use App\Models\Grupo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAcaoRequest;
use App\Http\Requests\UpdateAcaoRequest;
use App\Http\Requests\ImportarAcaoRequest;

class AcaoController extends Controller
{
    public function capturarAcoesB3(ImportarAcaoRequest $request, Grupo $grupo)
    {

        $client = curl_init();

        $params = [
            'range' => $request->only('faixa')['faixa'],
            'interval' => $request->only('intervalo')['intervalo'],
            'fundamental' => true,
            'dividends' => true,
            'token' => env('BRAPI_TOKEN')
        ];

        curl_setopt_array($client, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => 'https://brapi.dev/api/quote/' .
            implode(",", $request->only('empresas')['empresas']) .
            '?' . http_build_query($params),
        ]);

        $response = curl_exec($client);

        $apiData = json_decode($response);

        $acoes = [];

        curl_close($client);

        foreach ($apiData->results as $apiAcao) {
            $acao = new Acao([
                'simbolo' => $apiAcao->symbol,
                'nome_curto' => $apiAcao->shortName,
                'nome_completo' => $apiAcao->longName,
                'preco_merc_regular' => $apiAcao->regularMarketPrice,
                'alto_merc_regular' => $apiAcao->regularMarketDayHigh,
                'baixo_merc_regular' => $apiAcao->regularMarketDayLow,
                'intervalo_merc_regular' => $apiAcao->regularMarketDayRange,
                'variacao_merc_regular' => $apiAcao->regularMarketChange,
                'valor_merc' => $apiAcao->marketCap,
                'volume_merc_regular' => $apiAcao->regularMarketVolume,
                'fecha_ant_merc_regular' => $apiAcao->regularMarketPreviousClose,
                'abertura_merc_regular' => $apiAcao->regularMarketOpen,
                'link_logo' => $apiAcao->logourl,
                'preco_lucro' => $apiAcao->priceEarnings,
                'data_importacao' => now(),
                'id_grupo' => $grupo->id
            ]);
            $acao->save();
            array_push($acoes, $acao);
        }

        return [
            'status' => true,
            'dados_importados' => $acoes
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Grupo $grupo)
    {
        $acoes = Acao::all()
            ->where('id_grupo', $grupo->id) 
            ->values();

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
}
