<?php

namespace App\Http\Controllers;

use App\Models\Acao;
use App\Models\Grupo;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportarAcaoRequest;
use App\Models\AcaoHistorico;
use App\Models\Dividendo;
use Illuminate\Support\Carbon;

class AcaoController extends Controller
{
    public function capturarAcoesB3(ImportarAcaoRequest $request, Grupo $grupo)
    {

        $client = curl_init();

        $params = [
            'range' => $request->only('faixa')['faixa'],
            'interval' => $request->only('intervalo')['intervalo'],
            'fundamental' => 'true',
            'dividends' => 'true',
            'token' => env('BRAPI_TOKEN')
        ];

        $curl_url = 'https://brapi.dev/api/quote/' .
            implode(",", $request->only('empresas')['empresas']) .
            '?' . http_build_query($params);

        curl_setopt_array($client, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => $curl_url
        ]);

        $response = curl_exec($client);

        $apiData = json_decode($response);

        $acoes = [];

        curl_close($client);

        foreach ($apiData->results as $apiAcao) {

            $acao = new Acao([
                'simbolo' => !empty($apiAcao->symbol) ? $apiAcao->symbol : "N/A",
                'nome_curto' => !empty($apiAcao->shortName) ? $apiAcao->shortName : "N/A",
                'nome_completo' => !empty($apiAcao->longName) ? $apiAcao->longName : "N/A",
                'preco_merc_regular' => !empty($apiAcao->regularMarketPrice) ? $apiAcao->regularMarketPrice : "N/A",
                'alto_merc_regular' => !empty($apiAcao->regularMarketDayHigh) ? $apiAcao->regularMarketDayHigh : "N/A",
                'baixo_merc_regular' => !empty($apiAcao->regularMarketDayLow) ? $apiAcao->regularMarketDayLow : "N/A",
                'intervalo_merc_regular' => !empty($apiAcao->regularMarketDayRange) ? $apiAcao->regularMarketDayRange : "N/A",
                'variacao_merc_regular' => !empty($apiAcao->regularMarketChange) ? $apiAcao->regularMarketChange : "N/A",
                'valor_merc' => !empty($apiAcao->marketCap) ? $apiAcao->marketCap : "N/A",
                'volume_merc_regular' => !empty($apiAcao->regularMarketVolume) ? $apiAcao->regularMarketVolume : "N/A",
                'fecha_ant_merc_regular' => !empty($apiAcao->regularMarketPreviousClose) ? $apiAcao->regularMarketPreviousClose : "N/A",
                'abertura_merc_regular' => !empty($apiAcao->regularMarketOpen) ? $apiAcao->regularMarketOpen : "N/A",
                'link_logo' => !empty($apiAcao->logourl) ? $apiAcao->logourl : "N/A",
                'preco_lucro' => !empty($apiAcao->priceEarnings)? $apiAcao->priceEarnings : "N/A",
                'data_importacao' => now(),
                'id_grupo' => $grupo->id
            ]);

            $acao->save();

            if (isset($apiAcao->dividendsData->cashDividends)) {

                foreach ($apiAcao->dividendsData->cashDividends as $dividendo) {

                    $dividendo = new Dividendo([
                        'ativo_emitido' => $dividendo->assetIssued,
                        'taxa' => $dividendo->rate,
                        'relacionado' => $dividendo->relatedTo,
                        'rotulo' => $dividendo->label,
                        'codigoISIN' => $dividendo->isinCode,
                        'id_acao' => $acao->id
                    ]);

                    $dividendo->save();
                }
            }

            if (isset($apiAcao->historicalDataPrice)) {

                foreach ($apiAcao->historicalDataPrice as $historico) {

                    $historico = new AcaoHistorico([
                        'data_acao' => Carbon::createFromTimestamp($historico->date)->format('Y-m-d'),
                        'preco_abertura' => $historico->open,
                        'preco_mais_alto' => $historico->high,
                        'preco_mais_baixo' => $historico->low,
                        'preco_fechamento' => $historico->close,
                        'preco_fechamento_ajustado' => $historico->adjustedClose,
                        'id_acao' => $acao->id
                    ]);

                    $historico->save();
                }
            }

            array_push($acoes, $acao);
        }

        $grupo->update(['etapa' => "Demonstrativo"]);

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

        foreach ($acoes as $acao) {
            $acao->getDemontrativos();
            $acao->planilha_grupo = json_decode($acao->planilha_grupo);
        }

        return [
            "status" => true,
            'data' => $acoes
        ];
    }


    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(StoreAcaoRequest $request)
    // {
    //     $acoes = Acao::create($request->all());
    //     $acoes->save();

    //     return [
    //         'status' => 1,
    //         'data' => $acoes
    //     ];
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Acao $acao)
    // {
    //     return [
    //         "status" => true,
    //         "data" => $acao
    //     ];
    // }
}
