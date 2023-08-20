<?php

use App\Http\Controllers\DocenteController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\TipoDeUsuarioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;

/*
|--------------------------------------------------------------------------
| Rotas para autenticar o usuário (login/logout)
|--------------------------------------------------------------------------
*/

Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);

Route::resources([
    'turma' => TurmaController::class,
    'docente' => DocenteController::class,
    'tipoDeUsuario' => TipoDeUsuarioController::class
]);

/*
|--------------------------------------------------------------------------
| Rotas que necessitam de autenticação, sendo seguidas por validações de permissão do usuário
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {

    Route::get('cursos', [CursoController::class, 'index']);

    Route::middleware('scope:admin')->group(function () {
    });

    Route::middleware('scopes:admin,coordenador')->group(function () {
    });

    Route::middleware('scopes:docencia')->group(function () {
        
    });

    Route::middleware('scopes:admin,aluno')->group(function () {
    });
    
});
