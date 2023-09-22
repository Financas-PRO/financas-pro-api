<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreTurmaRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'ano' => ['required', Rule::unique('turmas')->where(function ($query) use ($request) {
                return $query->where('ano', $request->input('ano'))
                    ->where('semestre', $request->input('semestre'))
                    ->where('descricao', $request->input('descricao'));
            }), 'size:4'],
            'semestre' => ['required',  Rule::unique('turmas')->where(function ($query) use ($request) {
                return $query->where('ano', $request->input('ano'))
                    ->where('semestre', $request->input('semestre'))
                    ->where('descricao', $request->input('descricao'));
            }), 'size:1'],
            'descricao' => ['required',  Rule::unique('turmas')->where(function ($query) use ($request) {
                return $query->where('ano', $request->input('ano'))
                    ->where('semestre', $request->input('semestre'))
                    ->where('descricao', $request->input('descricao'));
            })]
        ];
    }


    public function messages(): array
    {
        return [
            'ano.required' => 'O ano é obrigatório.',
            'ano.size' => 'Use o ano com 4 números (Ex: 2016).',
            'semestre.required' => 'O semestre é obrigatório.',
            'semestre.size' => 'O semestre deve conter apenas um número.',
            'turma.required' => 'A turma é obrigatória.',
            'turma.size' => 'O campo turma deve ser definida com apenas 1 letra.',
        ];
    }
}
