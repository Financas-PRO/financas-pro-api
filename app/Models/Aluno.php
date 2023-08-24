<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Curso;
use stdClass;

class Aluno extends Model
{
    protected $with = ['user', 'curso'];

    protected $fillable = [
        'nome',
        'ra',
        'id_usuario',
        'id_curso',
        'termo'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }

    public function curso(){
        return $this->hasOne(Curso::class, 'id', 'id_curso');
    }

    public static function importarAlunos($string){

        $alunos = [];

        $data_alunos = array_filter(preg_split('/\r\n|\r|\n/', $string));

        foreach ($data_alunos as $data_aluno){

            $info_aluno = array_filter(explode(';', $data_aluno));

            $objAluno = new stdClass();

            $propiedades = ['curso', 'disciplina', 'termo', 'turma', 'ano', 
            'semestre', 'cod_disciplina', 'username', 'ra', 'nome', 'email'];

            foreach ($info_aluno as $key => $prop_valor){

                $prop = $propiedades[$key];
                $objAluno->$prop = $prop_valor;
            }

            array_push($alunos, $objAluno);
        }

        return $alunos;
    }
}
