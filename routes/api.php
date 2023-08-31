<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\TipoDeUsuarioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcaoController;
use App\Http\Controllers\GrupoController;

/*
|--------------------------------------------------------------------------
| Rotas para autenticar o usuário (login/logout)
|--------------------------------------------------------------------------
*/

Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);
Route::post('acoes', [AcaoController::class, 'capturarAcoesB3']);

Route::post('importarAlunos/{turma}', [AlunoController::class, 'importarAlunos']);

Route::resources([
    'turma' => TurmaController::class,
    'docente' => DocenteController::class,
    'tipoDeUsuario' => TipoDeUsuarioController::class
]);

// Rotas: grupo (apenas POST, GET e DELETE)
Route::post('grupo/{turma}', [GrupoController::class, 'store']);
Route::delete('grupo/{grupo}', [GrupoController::class, "destroy"]);

/*
|--------------------------------------------------------------------------
| Rotas que necessitam de autenticação, sendo seguidas por validações de permissão do usuário
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    
    Route::middleware('scope:admin')->group(function () {

        // Route::resources([
        //     'turma' => TurmaController::class,
        //     'docente' => DocenteController::class,
        //     'tipoDeUsuario' => TipoDeUsuarioController::class,
        //     'aluno' => AlunoController::class
        // ]);
    });

    Route::middleware('scope:admin,docencia')->group(function () {
        
    });

    Route::middleware('scope:admin,aluno')->group(function () {
    });
    
});
