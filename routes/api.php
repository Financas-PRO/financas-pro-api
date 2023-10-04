<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\TipoDeUsuarioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AcaoController;
use App\Http\Controllers\AnaliseGrupoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DisciplinaController;
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

/*
|--------------------------------------------------------------------------
| MIDDLEWARE: autenticação, sendo seguidas por validações de permissão do usuário.
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {

    Route::middleware('scope:admin')->group(function () { // Rotas protegidas por permissões. Apenas administradores.

        Route::get("scopeAdmin", function(){
            return auth()->user();
        });

        Route::resources([
            'tipoDeUsuario' => TipoDeUsuarioController::class,
            'disciplina' => DisciplinaController::class,
            'curso' => CursoController::class,
            'docente' => DocenteController::class
        ]);

    });

    Route::middleware('scope:admin,docencia')->group(function () { // Rotas protegidas por permissões. Apenas administradores e docentes.

        Route::get("scopeDoc", function(){
            return auth()->user();
        });

        Route::resource('turma', TurmaController::class);
        Route::post('feedback/{grupo}', [FeedbackController::class, 'store']);
        Route::put('feedback/{feedback}', [FeedbackController::class, 'update']);
        Route::post('importarAlunos/{turma}', [AlunoController::class, 'importarAlunos']);

    });

    Route::middleware('scope:admin,aluno')->group(function () { // Rotas protegidas por permissões. Apenas administradores e alunos.

        Route::get("scopeAluno", function(){
            return auth()->user();
        });

        Route::post('analise/{grupo}', [AnaliseGrupoController::class, 'store']);
        Route::put('analise/{analiseGrupo}', [AnaliseGrupoController::class, 'update']);
        Route::post('grupo/{turma}', [GrupoController::class, 'store']);
        Route::delete('grupo/{grupo}', [GrupoController::class, 'destroy']);
        Route::get('grupo/{turma}', [GrupoController::class, 'index']);
        Route::post('acoes/{grupo}', [AcaoController::class, 'capturarAcoesB3']);

    });

    Route::get("relacaoTurma/{turma}", [AlunoController::class, 'retornaRelacaoTurma']);
    Route::get('turma', [TurmaController::class, 'index']);


});
/* ------------------------------------------------------------------------ */