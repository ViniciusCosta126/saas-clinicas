<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clinicaId = auth()->user()->clinica->id;

        return [
            'nome_clinica' => 'required|string|max:255',
            'nome_responsavel' => 'required|string|max:255',
            'email' => "required|email|unique:clinicas,email,{$clinicaId}",
            'telefone' => 'required|string|size:11',
            'preco_min_consulta' => 'required|numeric|min:1',
            'preco_max_consulta' => 'required|numeric|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'nome_clinica.required' => 'O nome da clínica é obrigatório.',
            'nome_responsavel.required' => 'O nome do responsável é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.size' => 'O telefone deve ter 11 dígitos.',
            'preco_min_sessao.required' => 'Informe o preço mínimo da sessão.',
            'preco_max_sessao.required' => 'Informe o preço máximo da sessão.',
            'preco_min_sessao.numeric'  => 'O preço mínimo da sessão deve ser um valor numérico.',
            'preco_max_sessao.numeric' => 'O preço máximo da sessão deve ser um valor numérico.',
        ];
    }
}