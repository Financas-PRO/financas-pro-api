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
}
