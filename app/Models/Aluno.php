<?php

namespace App\Models;

use App\Mail\EnviarCredenciaisEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Curso;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use stdClass;

class Aluno extends Model
{
    protected $with = ['user', 'curso'];

    protected $fillable = [
        'nome',
        'ra',
        'id_usuario',
        'id_curso',
        'termo',
        'id_disciplina'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'id_usuario',
        'id_curso',
        'ativo'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }

    public function curso()
    {
        return $this->hasOne(Curso::class, 'id', 'id_curso');
    }

    public function tratarArquivoAlunos($string)
    {

        $alunos = [];

        $data_alunos = array_filter(preg_split('/\r\n|\r|\n/', $string));

        foreach ($data_alunos as $data_aluno) {

            $info_aluno = array_filter(explode(';', $data_aluno));

            $objAluno = new stdClass();

            $propiedades = [
                'curso', 'disciplina', 'termo', 'turma', 'ano',
                'semestre', 'cod_disciplina', 'username', 'ra', 'nome', 'email'
            ];

            foreach ($info_aluno as $key => $prop_valor) {

                $prop = $propiedades[$key];
                $objAluno->$prop = $prop_valor;
            }

            array_push($alunos, $objAluno);
        }

        return $alunos;
    }

    public function importarAlunos($alunos)
    {

        $importados = [];

        foreach ($alunos as $aluno) {

            $curso = DB::table('cursos')->where('curso', $aluno->curso)->first();
            $disciplina = DB::table('disciplinas')->where('nome', $aluno->disciplina)->first();

            $user = (new User())->findForPassport($aluno->username);

            if (is_null($user)) {

                $model_usuario = new User([
                    'username' => $aluno->username, 'password' => $this->gerarSenha(["nome" => $aluno->nome, "ra" => $aluno->ra]),
                    "email" => $aluno->email, 'id_tipoDeUsuario' => 3
                ]);
                $model_usuario->save();

                $model_aluno = new Aluno([
                    'nome' => $aluno->nome, 'ra' => $aluno->ra, 'id_usuario' => $model_usuario->id, "id_curso" => $curso->id,
                    'termo' => $aluno->termo, 'id_disciplina' => $disciplina->id
                ]);
                $model_aluno->save();

                array_push($importados, Aluno::find($model_aluno->id));
            } else {
                array_push($importados, $this->atualizarAluno($aluno, $curso->id));
            }
        }

        return $importados;
    }

    private function gerarSenha($info)
    {
        $nome = explode(" ", $info["nome"]);
        $ra = substr($info["ra"], -3);

        return $nome[0] . $nome[1] . "@" . $ra;
    }

    public function enviarEmail($aluno)
    {
    $senha = $this->gerarSenha(["nome" => $aluno->nome, "ra" => $aluno->ra]);

    $data = [
        'username' => $aluno->user->username,
        'password' => $senha,
    ];

    $destinatario = $aluno->user->email;

    if ($destinatario) {
        Mail::to($destinatario)->send(new EnviarCredenciaisEmail($data));
    } else {
        Log::error('Endereço de e-mail não disponível para o aluno' . $aluno->id);
    }
}



    private function atualizarAluno($aluno, $cursoid)
    {

        $model_usuario = User::where("username", $aluno->username)->first();
        $model_aluno = Aluno::where("id_usuario", $model_usuario->id)->first();

        $model_aluno->update(["id_curso" => $cursoid, 'termo' => $aluno->termo]);

        return $model_aluno;
    }
}
