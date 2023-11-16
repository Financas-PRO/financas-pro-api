<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AnaliseGrupo extends Model
{
    protected $fillable = [
        'id_grupo',
        'descricao'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'ativo'
    ];

    public static function getAnaliseAluno(Collection $alunos, int $turma){
        return DB::table('analise_grupos')
        ->join('grupos', 'grupos.id', '=', 'analise_grupos.id_grupo')
        ->join('aluno_grupos', 'aluno_grupos.id_grupo', '=', 'grupos.id')
        ->join('turmas', 'turmas.id', '=', 'grupos.id_turma')
        ->where('grupos.id_turma', '=', $turma)
        ->whereIn('aluno_grupos.id_aluno', $alunos)
        ->get()
        ->count();
    }
}
