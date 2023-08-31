<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportarAcaoRequest extends FormRequest
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
            "empresas" => "required",
            "faixa" => "required",
            "intervalo" => "required"
        ];
    }

    public function messages(): array {

        return [
            'empresas.required' => 'Por favor, envie as empresas.',
            'faixa.required' => 'Por favor, digite a faixa.',
            'intervalo.required' => 'Por favor, digite o intervalo.',
        ];
    }
}
