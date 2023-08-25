<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
        'id_usuario',
        'id_curso',
        'ativo'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }

    public function curso(){
        return $this->hasOne(Curso::class, 'id', 'id_curso');
    }

    /**
     * TODO: se o aluno já está registrado no sistema, procurar os dados pelo username que vem do txt
     * e atualizar? Como lidar com alunos que estão em mais de um curso, termo, turma...
     */
    public function tratarArquivoAlunos($string){

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

    public function importarAlunos($alunos){

        $importados = [];

        foreach ($alunos as $aluno) {

            // $disciplina = Disciplina::where('nome', $aluno->disciplina);
            $curso = DB::table('cursos')->where('curso', $aluno->curso)->first();

            $model_usuario = new User(['username' => $aluno->username, 'password' => $this->gerarSenha(["nome" => $aluno->nome, "ra" => $aluno->ra]),
            "email" => $aluno->email, 'id_tipoDeUsuario' => 3]);
            $model_usuario->save();

            $model_aluno = new Aluno(['nome' => $aluno->nome, 'ra' => $aluno->ra, 'id_usuario' => $model_usuario->id, "id_curso" => $curso->id, 
            'termo' => $aluno->termo]);
            $model_aluno->save();

            array_push($importados, Aluno::find($model_aluno->id));

        };

        return $importados;
    }

    private function gerarSenha($info){

        $nome = explode(" ", $info["nome"]);
        $ra = substr($info["ra"], -3);

        return $nome[0] . $nome[1] . "@" . $ra;

    }
}
