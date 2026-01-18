<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreAgendamentoRequest extends FormRequest
{
    /**
     * Permitir que apenas usuários logados façam o agendamento.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Regras de validação.
     */
    public function rules(): array
    {
        return [
            'clinica_id'      => 'required|exists:clinicas,id',
            'profissional_id' => 'required|exists:users,id',
            'paciente_id'     => 'required|exists:pacientes,id',
            'data'            => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'horario_inicio'  => 'required|date_format:H:i',
            'horario_fim'     => 'required|date_format:H:i|after:horario_inicio',
            'status'          => 'required|in:agendado,confirmado,pendente,cancelado',
        ];
    }

    public function messages(): array
    {
        return [
            'data.after_or_equal' => 'Não é possível agendar em uma data que já passou.',
            'horario_fim.after'   => 'O horário de término deve ser depois do horário de início.',
            'paciente_id.required' => 'Você precisa selecionar um paciente.',
            'horario_inicio.required' => 'Selecione um horário disponível.',
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->input('data');
            $inicio = $this->input('horario_inicio');

            if ($data && $inicio) {
                $agendamento = Carbon::parse($data . ' ' . $inicio);
                if ($agendamento->isPast()) {
                    $validator->errors()->add('horario_inicio', 'Este horário já passou para o dia de hoje.');
                }
            }
        });
    }
}