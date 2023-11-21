<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
    public function rules(Request $request): array
    {
        return [
            'ano' => ['required', Rule::unique('turmas')->where(function ($query) use ($request) {
                return $query->where('ano', $request->input('ano'))
                    ->where('semestre', $request->input('semestre'))
                    ->where('descricao', $request->input('descricao'))
                    ->where('id', '!=', $this->route('turma')->id);
            }), 'size:4'],
            'semestre' => ['required',  Rule::unique('turmas')->where(function ($query) use ($request) {
                return $query->where('ano', $request->input('ano'))
                    ->where('semestre', $request->input('semestre'))
                    ->where('descricao', $request->input('descricao'))
                    ->where('id', '!=', $this->route('turma')->id);
            }), 'size:1'],
            'descricao' => ['required',  Rule::unique('turmas')->where(function ($query) use ($request) {
                return $query->where('ano', $request->input('ano'))
                    ->where('semestre', $request->input('semestre'))
                    ->where('descricao', $request->input('descricao'))
                    ->where('id', '!=', $this->route('turma')->id);
            })]
        ];
    }
    public function messages(): array{
        return [
            'ano.required' => 'O ano é obrigatório.',
            'ano.size' => 'Use o ano com 4 números (Ex: 2016).',
            'semestre.required' => 'O semestre é obrigatório.',
            'descricao.required' => 'A descrição é obrigatória.',
            //'descricao.filled' => 'A descrição de turma é obrigatória.',
        ];
    }
}
