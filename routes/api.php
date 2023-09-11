<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\TipoDeUsuarioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AcaoController;
use App\Http\Controllers\AnaliseGrupoController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GrupoController;

/*
|--------------------------------------------------------------------------
| ROTAS: autenticar o usuário
|--------------------------------------------------------------------------
*/
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);
/* ------------------------------------------------------------------------ */

Route::post('acoes', [AcaoController::class, 'capturarAcoesB3']);

/*
|--------------------------------------------------------------------------
| ROTA: importar alunos por TXT 
|--------------------------------------------------------------------------
*/
Route::post('importarAlunos/{turma}', [AlunoController::class, 'importarAlunos']);
/* ------------------------------------------------------------------------ */

Route::resources([
    'turma' => TurmaController::class,
    'docente' => DocenteController::class,
    'tipoDeUsuario' => TipoDeUsuarioController::class
]);

/*
|--------------------------------------------------------------------------
| ROTAS: Criar e deletar grupo
|--------------------------------------------------------------------------
*/
Route::post('grupo/{turma}', [GrupoController::class, 'store']);
Route::delete('grupo/{grupo}', [GrupoController::class, "destroy"]);
/* ------------------------------------------------------------------------ */

/*
|--------------------------------------------------------------------------
| ROTAS: Feedback e Análise do grupo
|--------------------------------------------------------------------------
*/
Route::post('feedback/{grupo}', [FeedbackController::class, 'store']);
Route::put('feedback/{feedback}', [FeedbackController::class, 'update']);
Route::post('analise/{grupo}', [AnaliseGrupoController::class, 'store']);
Route::put('analise/{analiseGrupo}', [AnaliseGrupoController::class, 'update']);
/* ------------------------------------------------------------------------ */


Route::get("relacaoTurma/{turma}", [AlunoController::class, 'retornaRelacaoTurma']);

/*
|--------------------------------------------------------------------------
| MIDDLEWARE: autenticação, sendo seguidas por validações de permissão do usuário.
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    
    Route::middleware('scope:admin')->group(function () {

    });

    Route::middleware('scope:admin,docencia')->group(function () {
        
    });

    Route::middleware('scope:admin,aluno')->group(function () {
        
    });
    
});
/* ------------------------------------------------------------------------ */