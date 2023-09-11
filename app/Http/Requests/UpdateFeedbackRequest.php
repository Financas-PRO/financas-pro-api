<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeedbackRequest extends FormRequest
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
            'descricao' => 'required',
            'id_docente' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'descricao.required' => 'Por favor, digite a análise que você chegou.',
            'id_docente.required' => 'Por favor, envie o docente' //TODO: retirar validação no futuro, pois ele vai buscar automático pela autenticação do usuário
        ];
    }
}
