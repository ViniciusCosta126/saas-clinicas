<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestPaciente extends FormRequest
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
            'email' => "required|email|unique:profissionais,email,NULL,id,clinica_id,{$clinicaId},deleted_at,NULL",
            "telefone"=>"required|string|max:11",
            "clinica_id" => "exists:clinicas,id",
            "aniversario"=>""
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

            'telefone.required' => 'O telefone do profissional é obrigatório.',
            'telefone.string' => 'O telefone do profissional deve ser um texto válido.',
            'telefone.max' => 'O telefone do profissional pode ter no máximo 11 caracteres.',
        
            'clinica_id.exists' => 'A clínica informada não é válida.',
        ];
    }
}
