<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;

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
                    $token = $usuario->createToken('FinPro', ['docente'])->accessToken;
                    break;

                case 3:
                    $token = $usuario->createToken('FinPro', ['aluno'])->accessToken;
                    break;

                case 4:
                    $token = $usuario->createToken('FinPro', ['coordenador'])->accessToken;
                    break;
            }

            return response()->json([
                "status" => true
            ], 200)->withCookie(cookie('token', $token));;
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

            return response()->json(['success' => 'logout_success'], 200);
        } else {
            return response()->json(['error' => 'api.something_went_wrong'], 500);
        }
    }
}
