<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    public function render($request, Throwable $e)
    {
        $e = $this->prepareException($e);

        switch (true) {
            case $e instanceof HttpResponseException:
                return $e->getResponse();
                break;

            case $e instanceof AuthenticationException:
                return $this->prepararJson("O usuário não foi autorizado a realizar essa requisição." .  $request->cookie('laravel_token'), 401);

                break;

            case $e instanceof ValidationException:
                return $this->prepararJson($e->errors(), 422);

                break;

            default:
                return $this->prepararJson(env("APP_DEBUG") ? $e->getMessage() : "Ocorreu um erro interno. Por favor, 
                contate o administrador do sistema.", 500);
        }
    }

    public function prepararJson($mensagem, $http)
    {
        return response()->json([
            "status" => false,
            "error" => $mensagem
        ], $http);
    }
}
