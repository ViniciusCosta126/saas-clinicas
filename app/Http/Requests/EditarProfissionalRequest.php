<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarProfissionalRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'preco_sessao' => ['required', 'numeric', 'min:0'],
            'especialidade' => ['required', 'string', 'min:2'],
        ];
    }

    public function messages(): array
    {
        return [
            'preco_sessao.required' => 'Informe o preço da sessão',
            'preco_sessao.numeric' => 'O preço da sessão deve ser um valor numérico',
            'preco_sessao.min' => 'O preço da sessão não pode ser negativo',

            'especialidade.required' => 'A especialidade é obrigatória',
        ];
    }
}
