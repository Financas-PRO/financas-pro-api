<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportarAlunoRequest extends FormRequest
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
            'txt' => 'required|file|mimes:txt'
        ];
    }

    public function messages(): array {

        return [
            'txt.required' => 'Por favor, envie o arquivo para realizar a importação.',
            'txt.mimes' => 'Por favor, envie o arquivo em formato txt.'
        ];
    }
}
