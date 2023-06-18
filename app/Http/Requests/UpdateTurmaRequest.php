<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTurmaRequest extends FormRequest
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
            'ano' => 'required|size:4',
            'semestre' => 'required',
            'curso' => 'required',
            'turma' => 'required|size:1',
        ];
    }
    public function messages(): array{
        return [
            'ano.required' => 'O ano é obrigatório.',
            'ano.size' => 'Use o ano com 4 números (Ex: 2016).',
            'semestre.required' => 'O semestre é obrigatório.',
            'curso.required' => 'O curso é obrigatório.',
            'turma.required' => 'A turma é obrigatória.',
            'turma.size' => 'O campo turma deve ser definida com apenas 1 letra.',
        ];
    }
}
