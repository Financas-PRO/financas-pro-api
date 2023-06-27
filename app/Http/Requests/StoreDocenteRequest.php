<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocenteRequest extends FormRequest
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
            'rg' => 'required|size:9',
            'cpf' => 'required|size:14',
            'telefone' => 'required',
            "username" => "required",
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'id_tipoDeUsuario' => 'required'
        ];
    }

    public function messages(): array {
        return [
            "nome.required" => "O campo de nome é obrigatório.",
            "email.required" => "O campo de email é obrigatório.",
            "email.unique" => "Esse email já está sendo usado por outra pessoa.",
            "email.email" => "Por favor, informe um endereço de email válido.",
            "rg.required" => "O RG é obrigatório.",
            "rg.size" => "Por favor, digite apenas 9 digítos para o RG.",
            "cpf.required" => "O CPF é obrigatório.",
            "cpf.size" => "O CPF precisa ter 14 dígitos.",
            "telefone.required" => "O telefone é obrigatório",
            "telefone.size" => "Insira 11 dígitos para o telefone, use seu DDD.",
            "username.required" => "Você precisa de um usuário para fazer login no sistema.",
            "password.required" => "Voce precisa de uma senha para fazer login no sistema.",
            "password.size" => "A senha precisa ter no mínimo 3 caracteres.",
            "titulacao.required" => "A titulação é obrigatória.",
            "id_tipoDeUsuario" => "O tipo de usuário é obrigatório."
        ];

    }
}
