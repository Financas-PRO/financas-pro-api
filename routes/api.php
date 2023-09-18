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

use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| ROTAS: autenticar o usuário
|--------------------------------------------------------------------------
*/

Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);
/* ------------------------------------------------------------------------ */


/*
|--------------------------------------------------------------------------
| MIDDLEWARE: autenticação, sendo seguidas por validações de permissão do usuário.
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {

    Route::middleware('scope:admin')->group(function () {

        Route::get('passport', function () {
            Artisan::call('passport:install');
        });

        Route::resources([
            'turma' => TurmaController::class,
            'docente' => DocenteController::class,
            'tipoDeUsuario' => TipoDeUsuarioController::class
        ]);
    });

    Route::middleware('scope:admin,docencia')->group(function () {

        Route::get("relacaoTurma/{turma}", [AlunoController::class, 'retornaRelacaoTurma']);
        Route::post('feedback/{grupo}', [FeedbackController::class, 'store']);
        Route::put('feedback/{feedback}', [FeedbackController::class, 'update']);
        Route::post('importarAlunos/{turma}', [AlunoController::class, 'importarAlunos']);
    });

    Route::middleware('scope:admin,aluno')->group(function () {

        Route::post('analise/{grupo}', [AnaliseGrupoController::class, 'store']);
        Route::put('analise/{analiseGrupo}', [AnaliseGrupoController::class, 'update']);
        Route::post('grupo/{turma}', [GrupoController::class, 'store']);
        Route::delete('grupo/{grupo}', [GrupoController::class, "destroy"]);
        Route::post('acoes', [AcaoController::class, 'capturarAcoesB3']);
    });
});
/* ------------------------------------------------------------------------ */