<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grupo;
use App\Models\Docente;
use Illuminate\Support\Facades\DB;
use stdClass;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $with = ['grupo', 'docente'];

    protected $fillable = [
        'descricao',
        'id_docente',
        'id_grupo',
        'nota'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'ativo',
        'id_docente',
        'id_grupo'
    ];

    public function grupo(){
        return $this->hasOne(Grupo::class, 'id', 'id_grupo');
    }

    public function docente(){
        return $this->hasOne(Docente::class, 'id', 'id_docente');
    }

    public function getRelatorioNotas(int $id_turma){

        return DB::table('feedbacks')
        ->join('grupos', 'grupos.id', '=', 'feedbacks.id_grupo')
        ->join('aluno_grupos', 'aluno_grupos.id_grupo', '=', 'grupos.id')
        ->join('alunos', 'alunos.id', '=', 'aluno_grupos.id_aluno')
        ->join('cursos', 'cursos.id', '=', 'alunos.id_curso')
        ->select('alunos.nome', 'alunos.ra', 'feedbacks.nota', 'cursos.curso')
        ->where('grupos.id_turma', '=', $id_turma)
        ->get();

    }

    public function retornarPendencias(int $id_docente){
        $obj = new stdClass;

        $obj->concluidos = DB::table('feedbacks')
        ->join('grupos', 'grupos.id', '=', 'feedbacks.id_grupo')
        ->join('turmas', 'turmas.id', '=', 'grupos.id_turma')
        ->where('turmas.id_docente', '=', $id_docente)
        ->where('grupos.etapa', '=', 'Feedback concluído')
        ->get()
        ->count();


        $obj->pendencias = DB::table('feedbacks')
        ->join('grupos', 'grupos.id', '=', 'feedbacks.id_grupo')
        ->join('turmas', 'turmas.id', '=', 'grupos.id_turma')
        ->where('turmas.id_docente', '=', $id_docente)
        ->where('grupos.etapa', '=', 'Aguardando feedback')
        ->get()
        ->count();

        return $obj;

    }
}
