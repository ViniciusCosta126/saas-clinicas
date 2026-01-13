<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfissional extends FormRequest
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
        $clinicaId = auth()->user()->clinica->id;
        return [
            "nome" => "required|string|max:255",
            "email" => "required|email|unique:profissionais,email,NULL,id,clinica_id,{$clinicaId}",
            "especialidade" => "required|string|max:255",
            "preco_sessao" => "required|numeric",
            "clinica_id" => "exists:clinicas,id",
            "user_id" => "exists:users,id|required"
        ];
    }
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do profissional é obrigatório.',
            'nome.string' => 'O nome do profissional deve ser um texto válido.',
            'nome.max' => 'O nome do profissional pode ter no máximo 255 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Já existe um profissional com este e-mail cadastrado nesta clínica.',

            'especialidade.required' => 'A especialidade é obrigatória.',
            'especialidade.string' => 'A especialidade deve ser um texto válido.',
            'especialidade.max' => 'A especialidade pode ter no máximo 255 caracteres.',

            'preco_sessao.required' => 'O preço da sessão é obrigatório.',
            'preco_sessao.numeric' => 'O preço da sessão deve ser um valor numérico.',

            'clinica_id.exists' => 'A clínica informada não é válida.',
            "user_id.exists" => "O usuario informado não é valido",
            "user_id.required" => "O usuario é obrigatório",
        ];
    }
}
