<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Feedback;
use App\Models\Grupo;
use App\Models\Aluno;
use App\Models\Docente;
class UserController extends Controller
{
    public function login(LoginRequest $request)
    {

        $input = $request->all();

        $credenciais = [
            "username" => $input["username"],
            "password" => $input["password"]
        ];

        if (auth()->attempt($credenciais)) {

            $usuario = auth()->user();

            switch ($usuario->tipoDeUsuario->id) {
                case 1:
                    $token = $usuario->createToken('FinPro', ['admin'])->accessToken;
                    break;

                case 2:
                    $token = $usuario->createToken('FinPro', ['docencia'])->accessToken;
                    break;

                case 3:
                    $token = $usuario->createToken('FinPro', ['aluno'])->accessToken;
                    break;
            }

            return response()->json([
                "status" => true,
                "scope" => auth()->user()->tipoDeUsuario->papel,
                "user" => auth()->user()
            ], 200)->withCookie(cookie('laravel_token', $token, 0, null, null, true, true, false, "None"));

        } else {

            return response()->json([
                "status" => false,
                'error' => 'O usuário não foi autorizado a realizar essa requisição.'
            ], 401);
        }
    }

    public function logout()
    {
        if (auth()->check()) {
            auth()->user()->token()->revoke();

            return response()->json([
                'status' => false,
                'message' => 'Desconectado com sucesso.'
            ], 200);

        } else {
            return response()->json([
                'status' => false,
                'error' => 'Não foi possível revogar sua sessão. É provavél que seu token de acesso já tenha sido terminado.'
            ], 500);
        }
    }

    public function getDashboardInfo(){

        $usuario = auth()->user();

        switch ($usuario->tipoDeUsuario->id) {
            case 1:
                $model = new Feedback();
                $docente = (Docente::where('id_usuario', auth()->id())->first())->id;
                $data = $model->retornarPendencias($docente);
                break;

            case 2:
                $model = new Feedback();
                $docente = (Docente::where('id_usuario', auth()->id())->first())->id;
                $data = $model->retornarPendencias($docente);
                break;

            case 3:
                $model = new Grupo();
                $aluno = (Aluno::where('id_usuario', auth()->id())->first())->id;
                $data = $model->retornarUltimosGrupos($aluno);
                break;
        }

        return [
            'status' => true,
            'data' => $data
        ];
    }
}
