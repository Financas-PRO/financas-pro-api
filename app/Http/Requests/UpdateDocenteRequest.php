<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required',
            'titulacao' => 'required',
            'rg' => 'required',
            'cpf' => 'required',
            'telefone' => 'required',
            "username" => "required",
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'id_tipoDeUsuario' => 'required'
        ];
    }

    public function messages(): array {
        return[
                "nome.required" => "O campo de nome precisa ser preenchido!",
                "email.required" => "O campo de email precisa ser preenchido!",
                "email.unique" => "Esse email já está sendo usado por outra pessoa!",
                "email.email" => "Por favor, informe um endereço de email válido!",
                "rg.required" => "O campo de rg precisa ser preenchido!",
                "rg.size" => "O rg só tem 9 dígitos!",
                "cpf.required" => "O campo CPF precisa ser preenchido!",
                "cpf.size" => "O CPF precisa ter 11 dígitos!",
                "telefone.required" => "O campo telefone precisa ser preenchido!",
                "telefone.size" => "O telefone tem 11 dígitos, use seu DDD",
                "username.required" => "Voce precisa de um username para fazer login no sistema!",
                "password.required" => "Voce precisa de uma senha para fazer login no sistema!",
                "password.size" => "A senha precisa ter no mínimo 3 caracteres!",
                "titulacao.required" =>"O campo de titulação precisa ser preenchido!"



        ];

    }
}
